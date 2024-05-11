<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;

/**
 * \Playground\Make\Package\Building\BuildControllers
 */
trait BuildControllers
{
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

    public function build_crud(): void
    {
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

        $params_controller = [
            '--model-file' => '',
        ];

        if ($this->c->skeleton()) {
            $params_controller['--skeleton'] = true;
        }

        if ($force) {
            $params_controller['--force'] = true;
        }

        $params_controller['--namespace'] = $namespace;
        $params_controller['--package'] = $package;
        $params_controller['--organization'] = $this->c->organization();
        $params_controller['--model'] = '';
        $params_controller['--module'] = $this->c->module();

        if ($isApi) {
            $params_controller['--api'] = true;
            $params_controller['--policies'] = true;
            $params_controller['--requests'] = true;
            $params_controller['--routes'] = true;
            $params_controller['--swagger'] = true;
            $params_controller['--test'] = true;
            $params_controller['--type'] = 'playground-api';
        } elseif ($isResource) {
            // $params_controller['--blade'] = true;
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
        }

        foreach ($this->c->models() as $model => $file) {
            if (is_string($file) && $file) {

                $model = new Model($this->readJsonFileAsArray($file));

                $params_controller['--model'] = $model->name();
                $params_controller['name'] = Str::of($model->name())->studly()->finish('Controller')->toString();
                $params_controller['--model-file'] = $file;

                // dd([
                //     '__METHOD__' => __METHOD__,
                //     '$params_controller' => $params_controller,
                //     // '$this->c' => $this->c,
                // ]);
                $this->createControllerForModel($model, $package, $params_controller);

                // dd([
                //     '__METHOD__' => __METHOD__,
                //     '$this->c' => $this->c->toArray(),
                // ]);
            }
        }
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

        dump([
            '__METHOD__' => __METHOD__,
            '$params' => $params,
        ]);
        if (! $this->call('playground:make:controller', $params)) {
            $file_controller = sprintf(
                '%1$s/app/stub/%2$s/resources/packages/%3$s/controller.json',
                $this->laravel->storagePath(),
                $package,
                Str::of($model->name())->kebab()->toString()
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
