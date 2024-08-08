<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;

/**
 * \Playground\Make\Package\Building\BuildTests
 */
trait BuildTests
{
    // protected bool $createTest = false;

    public function createTest(): void
    {
        $type = $this->c->type();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        // ]);

        if (in_array($type, [
            'playground-model',
        ])) {
            $this->command_tests_providers('providers-model');
            $this->command_tests_playground_model();
            $this->command_tests_about_command();
            $this->command_tests_playground_model_test_case();
        } elseif (in_array($type, [
            'playground-api',
        ])) {
            $this->command_tests_providers('providers-api');
            $this->command_tests_playground_api();
            $this->command_tests_playground_request_test_case();
            $this->command_tests_playground_controller_test_case();
            $this->command_tests_playground_controller_route_tests();
            $this->command_tests_playground_service_provider();
            $this->command_tests_about_command();
        } elseif (in_array($type, [
            'playground-resource',
        ])) {
            $this->command_tests_providers('providers-resource');
            $this->command_tests_playground_resource();
            $this->command_tests_playground_request_test_case();
            $this->command_tests_playground_controller_test_case();
            $this->command_tests_playground_controller_route_tests();
            $this->command_tests_playground_service_provider();
            $this->command_tests_about_command();
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$this->c' => $this->c,
        //     '$this->options()' => $this->options(),
        // ]);
    }

    public function command_tests_playground_api(): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'TestCase',
            // '--namespace' => $this->c->namespace(),
            '--namespace' => $this->rootNamespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'playground-api-test-case',
        ];

        if ($this->c->playground()) {
            $options['--model-package'] = Str::of($this->c->packagist())->before('-api')->toString();
        }

        if ($this->c->revision()) {
            $options['--revision'] = true;
        }

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->c' => $this->c,
        // ]);

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);
    }

    public function command_tests_providers(string $type): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'PackageProviders',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => $type,
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $this->call('playground:make:test', $options);

        // $this->createTest = true;
    }

    public function command_tests_playground_model(): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'ModelCase',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'model-case',
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);

        // $this->createTest = true;
    }

    public function command_tests_playground_model_test_case(): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'TestCase',
            // '--namespace' => $this->c->namespace(),
            '--namespace' => $this->rootNamespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'playground-model-test-case',
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        if ($this->c->revision()) {
            $options['--revision'] = true;
        }

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);
    }

    public function command_tests_playground_resource(): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'TestCase',
            // '--namespace' => $this->c->namespace(),
            '--namespace' => $this->rootNamespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'playground-resource-test-case',
        ];

        if ($this->c->playground()) {
            $options['--model-package'] = Str::of($this->c->packagist())->before('-resource')->toString();
        }

        if ($this->c->revision()) {
            $options['--revision'] = true;
        }

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);
    }

    public function command_tests_playground_controller_test_case(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $type = $this->c->type();

        $options = [
            'name' => 'ControllerTestCase',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'playground-resource-controller-test-case',
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }

        if ($this->c->revision()) {
            $options['--revision'] = true;
        }

        if (in_array($type, [
            'playground-api',
        ])) {
            $options['--type'] = 'playground-api-controller-test-case';
        } elseif (in_array($type, [
            'playground-resource',
        ])) {
            $options['--type'] = 'playground-resource-controller-test-case';
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);
    }

    public function command_tests_playground_controller_route_tests(): void
    {
        // $isApi = $this->hasOption('api') && $this->option('api');
        // $isResource = $this->hasOption('resource') && $this->option('resource');
        $force = $this->hasOption('force') && $this->option('force');
        $type = $this->c->type();

        $options = [
            'name' => '',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--suite' => 'feature',
            '--type' => '',
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }

        if ($this->c->revision()) {
            $options['--revision'] = true;
        }

        // if ($isApi) {
        //     $options['--type'] = 'playground-api-controller-model-case';
        // } elseif ($isResource) {
        //     $options['--type'] = 'playground-resource-controller-model-case';
        // }

        if (in_array($type, [
            'playground-api',
        ])) {
            $options['--type'] = 'playground-api-controller-model-case';
        } elseif (in_array($type, [
            'playground-resource',
        ])) {
            $options['--type'] = 'playground-resource-controller-model-case';
        }

        $models = $this->modelPackage?->models() ?? [];
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$models' => $models,
        // ]);
        foreach ($models as $model => $file) {
            if (is_string($file) && $file) {

                $model = new Model($this->readJsonFileAsArray($file));

                if ($model->revision()) {
                    // Revision models do not have controllers.
                    continue;
                }
                $options['--model'] = $model->name();
                $options['name'] = Str::of($model->name())->studly()->finish('TestCase')->toString();
                $options['--model-file'] = $file;
                // dump([
                //     '__METHOD__' => __METHOD__,
                //     '$options' => $options,
                // ]);

                $this->call('playground:make:test', $options);

            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

    }

    public function command_tests_playground_request_test_case(): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'RequestTestCase',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'playground-request-test-case',
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);
    }

    public function command_tests_playground_service_provider(): void
    {
        $force = $this->hasOption('force') && $this->option('force');

        $options = [
            'name' => 'InstanceTest',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'playground-service-provider-policies',
        ];

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);
    }

    public function command_tests_about_command(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');

        $options = [
            'name' => 'CommandTest',
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--playground' => true,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--module' => $this->c->module(),
            '--type' => 'command-about',
        ];

        if ($isApi) {
            $options['--api'] = true;
        } elseif ($isResource) {
            $options['--resource'] = true;
        }

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->c' => $this->c,
        // ]);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);
    }
}
