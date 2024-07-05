<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;
use Playground\Make\Package\Configuration\Package;

/**
 * \Playground\Make\Package\Building\BuildControllers
 */
trait BuildControllers
{
    protected ?Package $modelPackage = null;

    public function handle_controllers(): void
    {
        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->controllers() as $controller) {
            if (is_string($controller) && $controller) {
                $params['--file'] = $controller;
                $this->call('playground:make:controller', $params);
            }
        }
    }

    public function load_model_package(string $model_package): void
    {
        $payload = $this->readJsonFileAsArray($model_package);
        if (! empty($payload)) {
            $this->modelPackage = new Package($payload);
            // $this->modelPackage->apply();
        }
    }

    public function build_crud_form_request(string $package, array $params): void
    {
        if (! $this->call('playground:make:request', $params)) {
            $file_request = sprintf(
                '%1$s/app/stub/%2$s/resources/packages/form.request.json',
                $this->laravel->storagePath(),
                $package,
            );
            $this->c->addClassFileTo('requests', $file_request);
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$file_request' => $file_request,
            //     '$package' => $package,
            //     // '$this->c' => $this->c->toArray(),
            //     '$this->c' => $this->c,
            // ]);
        }

    }

    public function build_crud(): void
    {
        $config_policies = '';
        $policy_line = '%1$s%2$s::class => %3$s\Policies\%4$sPolicy::class,%5$s';

        $force = $this->hasOption('force') && $this->option('force');
        // $withControllers = $this->hasOption('controllers') && $this->option('controllers');
        // $withPolicies = $this->hasOption('policies') && $this->option('policies');
        // $withRequests = $this->hasOption('requests') && $this->option('requests');
        // $withRoutes = $this->hasOption('routes') && $this->option('routes');
        // $withSwagger = $this->hasOption('swagger') && $this->option('swagger');
        // $withTests = $this->hasOption('test') && $this->option('test');

        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');

        $namespace = $this->c->namespace();

        if ($namespace) {
            $namespace = $this->parseClassConfig($namespace);
            if ($isApi) {
                $namespace = Str::of($namespace)->finish('/Api')->studly()->toString();
            } elseif ($isResource) {
                $namespace = Str::of($namespace)->finish('/Resource')->studly()->toString();
            }
        }

        $package = $this->c->package();
        if ($package && $this->c->playground()) {
            if ($isApi) {
                $package = Str::of($package)->finish('-api')->toString();
            } elseif ($isResource) {
                $package = Str::of($package)->finish('-resource')->toString();
            }
        }

        $params_form_request = [
            'name' => 'FormRequest',
            '--type' => 'form-request',
        ];

        $params_controller = [
            '--model-file' => '',
        ];

        if ($this->c->skeleton()) {
            $params_controller['--skeleton'] = true;
        }

        if ($force) {
            $params_controller['--force'] = true;
            $params_form_request['--force'] = true;
        }

        $params_controller['--namespace'] = $namespace;
        $params_controller['--package'] = $package;
        $params_controller['--organization'] = $this->c->organization();
        $params_controller['--model'] = '';
        $params_controller['--module'] = $this->c->module();

        $params_form_request['--namespace'] = $namespace;
        $params_form_request['--package'] = $package;
        $params_form_request['--organization'] = $this->c->organization();
        $params_form_request['--module'] = $this->c->module();

        if ($this->c->module_slug()) {
            $this->c->addRoute($this->c->module_slug());
        }

        if ($isApi) {
            $params_form_request['--api'] = true;
            $params_controller['--api'] = true;
            $params_controller['--policies'] = true;
            $params_controller['--requests'] = true;
            $params_controller['--routes'] = true;
            $params_controller['--swagger'] = true;
            $params_controller['--test'] = true;
            $params_controller['--type'] = 'playground-api';
        } elseif ($isResource) {
            $params_form_request['--resource'] = true;
            $params_controller['--blade'] = true;
            $params_controller['--policies'] = true;
            $params_controller['--requests'] = true;
            $params_controller['--resource'] = true;
            $params_controller['--routes'] = true;
            $params_controller['--swagger'] = true;
            $params_controller['--test'] = true;
            $params_controller['--type'] = 'playground-resource';
        }

        if ($this->c->playground()) {
            $params_controller['--playground'] = true;
            $params_form_request['--playground'] = true;
        }

        $this->build_crud_form_request($package, $params_form_request);

        $models = $this->modelPackage?->models() ?? [];
        foreach ($models as $model => $file) {
            if (is_string($file) && $file) {

                $model = new Model($this->readJsonFileAsArray($file));

                $params_controller['--model'] = $model->name();
                $params_controller['name'] = Str::of($model->name())->studly()->finish('Controller')->toString();
                $params_controller['--model-file'] = $file;

                // dump([
                //     '__METHOD__' => __METHOD__,
                //     '$params_controller' => $params_controller,
                //     // '$this->c' => $this->c,
                // ]);
                $this->createControllerForModel($model, $package, $params_controller);

                // Playground\Matrix\Models\Backlog::class => Playground\Matrix\Resource\Policies\BacklogPolicy::class,
                $config_policies .= sprintf($policy_line,
                    str_repeat(static::INDENT, 2),
                    $this->parseClassInput($model->fqdn()),
                    $this->parseClassInput($this->c->namespace()),
                    $model->model(),
                    PHP_EOL,
                );

                // dd([
                //     '__METHOD__' => __METHOD__,
                //     '$this->c' => $this->c->toArray(),
                // ]);
            }
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->routes()' => $this->c->routes(),
        // ]);

        if (! empty($config_policies)) {
            $this->searches['config_policies'] = rtrim($config_policies);
        }

        $this->make_service_provider_routes();
    }

    /**
     * Create a controller for the model.
     *
     * @param array<string, mixed> $params
     *
     * @see PolicyMakeCommand
     * @see SeederMakeCommand
     * @see TestMakeCommand
     */
    protected function createControllerForModel(
        Model $model,
        string $package,
        array $params = []
    ): void {

        $withCovers = $this->hasOption('covers') && $this->option('covers');
        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');
        $namespace = $this->c->namespace();

        if ($this->c->playground()) {
            $params['--playground'] = true;
        }

        if ($this->c->skeleton()) {
            $params['--skeleton'] = true;
        }

        if ($this->c->withTests()) {
            $params['--test'] = true;
        }

        if ($withCovers) {
            $params['--covers'] = true;
        }

        // if ($isApi || $isResource) {
        //     $params['--covers'] = true;
        // }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$params' => $params,
        // ]);
        if (! $this->call('playground:make:controller', $params)) {
            $model_slug = Str::of($model->name())->kebab()->toString();
            $model_plural_slug = Str::of($model->model_plural())->kebab()->toString();
            $file_controller = sprintf(
                '%1$s/app/stub/%2$s/resources/packages/%3$s/controller.json',
                $this->laravel->storagePath(),
                $package,
                $model_slug
            );
            $this->c->addClassFileTo('controllers', $file_controller);
            $file_route = sprintf(
                '%1$s/app/stub/%2$s/resources/packages/%3$s/route.json',
                $this->laravel->storagePath(),
                $package,
                $model_slug
            );
            if ($model_plural_slug) {
                $this->c->addRoute($model_plural_slug, $file_route);
            }

            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$file_controller' => $file_controller,
            //     '$package' => $package,
            //     // '$this->c' => $this->c->toArray(),
            //     '$this->c' => $this->c,
            // ]);
        }
    }

    /**
     * Create a base controller.
     *
     * @see PolicyMakeCommand
     * @see SeederMakeCommand
     * @see TestMakeCommand
     */
    protected function createBaseController(): void
    {
        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');

        $namespace = $this->c->namespace();

        if ($namespace) {
            $namespace = $this->parseClassConfig($namespace);
            if ($isApi) {
                $namespace = Str::of($namespace)->finish('/Api')->studly()->toString();
            } elseif ($isResource) {
                $namespace = Str::of($namespace)->finish('/Resource')->studly()->toString();
            }
        }

        $package = $this->c->package();
        if ($package && $this->c->playground()) {
            if ($isApi) {
                $package = Str::of($package)->finish('-api')->toString();
            } elseif ($isResource) {
                $package = Str::of($package)->finish('-resource')->toString();
            }
        }

        $params = [
            'name' => 'Controller',
            '--abstract' => true,
            '--namespace' => $namespace,
            '--package' => $package,
            '--module' => $this->c->module(),
            '--organization' => $this->c->organization(),
            '--type' => 'base',
        ];
        $namespace = $this->c->namespace();

        if ($this->c->playground()) {
            $params['--playground'] = true;
        }

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        if ($this->c->skeleton()) {
            $params['--skeleton'] = true;
        }

        // if ($this->c->withTests()) {
        //     $params['--test'] = true;
        // }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$params' => $params,
        // ]);
        if (! $this->call('playground:make:controller', $params)) {
            $file_controller = sprintf(
                '%1$s/app/stub/%2$s/resources/packages/controller.base.json',
                $this->laravel->storagePath(),
                $package,
            );
            $this->c->addClassFileTo('controllers', $file_controller);
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$file_controller' => $file_controller,
            //     '$package' => $package,
            //     // '$this->c' => $this->c->toArray(),
            //     '$this->c' => $this->c,
            // ]);
        }
    }

    /**
     * Create a resource index controller.
     *
     * @see PolicyMakeCommand
     * @see SeederMakeCommand
     * @see TestMakeCommand
     */
    protected function createResourceIndexController(): void
    {
        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');

        $model = '';
        if ($this->hasOption('model') && $this->option('model') && is_string($this->option('model'))) {
            $model = $this->option('model');
        }

        $namespace = $this->c->namespace();

        if ($namespace) {
            $namespace = $this->parseClassConfig($namespace);
            if ($isApi) {
                $namespace = Str::of($namespace)->finish('/Api')->studly()->toString();
            } elseif ($isResource) {
                $namespace = Str::of($namespace)->finish('/Resource')->studly()->toString();
            }
        }

        $package = $this->c->package();
        if ($package && $this->c->playground()) {
            if ($isApi) {
                $package = Str::of($package)->finish('-api')->toString();
            } elseif ($isResource) {
                $package = Str::of($package)->finish('-resource')->toString();
            }
        }

        $params = [
            'name' => 'IndexController',
            '--namespace' => $namespace,
            '--package' => $package,
            '--module' => $this->c->module(),
            '--organization' => $this->c->organization(),
            '--policies' => false,
            // '--routes' => true,
            '--type' => 'playground-resource-index',
        ];
        $namespace = $this->c->namespace();

        if ($this->c->playground()) {
            $params['--playground'] = true;
        }

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        if ($this->c->skeleton()) {
            $params['--skeleton'] = true;
        }

        // if ($this->c->withTests()) {
        //     $params['--test'] = true;
        // }

        if ($model) {
            $params['--model'] = $model;
            $models = $this->modelPackage?->models();
            if (is_array($models) && ! empty($models[$model])) {
                $params['--model-file'] = $models[$model];
            }

        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$params' => $params,
        //     // '$this->options()' => $this->options(),
        //     // '$this->modelPackage' => $this->modelPackage,
        // ]);
        if (! $this->call('playground:make:controller', $params)) {
            $file_controller = sprintf(
                '%1$s/app/stub/%2$s/resources/packages/index/controller.json',
                $this->laravel->storagePath(),
                $package,
            );
            $this->c->addClassFileTo('controllers', $file_controller);
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$file_controller' => $file_controller,
            //     '$package' => $package,
            //     // '$this->c' => $this->c->toArray(),
            //     '$this->c' => $this->c,
            // ]);
        }
    }
}
