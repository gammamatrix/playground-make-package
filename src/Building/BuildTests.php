<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

/**
 * \Playground\Make\Package\Building\BuildTests
 */
trait BuildTests
{
    protected bool $createTest = false;

    public function createTest(): void
    {
        $type = $this->c->type();

        if (in_array($type, [
            'playground-model',
        ])) {
            $this->command_tests_providers('providers-model');
            $this->command_tests_playground_model();
        } elseif (in_array($type, [
            'playground-api',
        ])) {
            $this->command_tests_providers('providers-api');
            $this->command_tests_playground_api();
        } elseif (in_array($type, [
            'playground-resource',
        ])) {
            $this->command_tests_providers('providers-esource');
            $this->command_tests_playground_resource();
        }
    }

    public function command_tests_playground_api(): void
    {
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

        $this->createTest = true;
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

        $this->createTest = true;
    }

    public function command_tests_playground_resource(): void
    {

    }
}
