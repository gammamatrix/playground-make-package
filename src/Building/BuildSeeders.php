<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Model;
use Playground\Make\Model\Configuration\Seeder;
use Playground\Make\Model\Configuration\SeederConfig;
use Playground\Make\Package\Configuration\Package;
use Playground\Make\Package\Console\Commands\PackageMakeCommand;

/**
 * \Playground\Make\Package\Building\BuildSeeders
 *
 * @mixin PackageMakeCommand
 */
trait BuildSeeders
{
    /**
     * @var array<string, Seeder>
     */
    protected array $seeders = [];

    /**
     * @var array<string, string[]>
     */
    protected array $seederSlugsByClass = [];

    /**
     * @var array<string, SeederConfig>
     */
    protected array $seederConfigs = [];

    /**
     * @var array<string, string>
     */
    protected array $seederFiles = [];

    /**
     * @var array<string, string>
     *
     * "seeders-tasks-primary": {
     * "file": "seeders-tasks--primary.php",
     * "type": "data",
     * "seeder": "\\Database\\Seeders\\Playground\\Task\\Models\\TaskPrimarySeeder",
     * "data": "resources/configurations/playground-task/seeders/seeders-tasks--primary.json"
     * },
     */
    protected array $seederConfigFiles = [];

    /**
     * Load from package: seeders.configs
     *
     * "seeders": {
     * "TaskPrimarySeeder": "resources/configurations/playground-task/seeders/task-primary-seeder.json",
     * "TaskSecondarySeeder": "resources/configurations/playground-task/seeders/task-secondary-seeder.json",
     * "TaskTertiarySeeder": "resources/configurations/playground-task/seeders/task-tertiary-seeder.json"
     * }
     */
    public function load_seeder_configs(): void
    {
        $seeders = $this->c->seeders();

        dd([
            '__METHOD__' => __METHOD__,
            '$seeders' => $seeders,
        ]);
        //        foreach ($models as $model => $file) {
        //            if (is_string($file) && $file) {
        //                $this->seederConfigFiles[$model] = $file;
        //                $this->seederConfigs[$model] = new SeederConfig($this->readJsonFileAsArray($file))->apply();
        //            }
        //        }
    }

    /**
     * Load from package: seeders.seeders
     */
    public function load_seeders(): void
    {
        $seeders = $this->c->seeders();

        dd([
            '__METHOD__' => __METHOD__,
            '$seeders' => $seeders,
        ]);
        //        $models = $this->c->models();
        //
        //        foreach ($models as $model => $file) {
        //            if (is_string($file) && $file) {
        //                $this->modelFiles[$model] = $file;
        //                $this->models[$model] = new Model($this->readJsonFileAsArray($file))->apply();
        //            }
        //        }
    }

    protected bool $preparedSeeders = false;

    public function prepare_seeders_data(): void
    {
        if ($this->preparedSeeders) {
            return;
        }

        $seeders = $this->c->seeders()['seeders'] ?? [];
        $configs = $this->c->seeders()['configs'] ?? [];

        foreach ($configs as $filename => $config) {
            if (empty($this->seederSlugsByClass[$config->seeder()])) {
                $this->seederSlugsByClass[$config->seeder()] = [];
            }
            $this->seederSlugsByClass[$config->seeder()][] = $filename;
        }

        dump([
            '__METHOD__' => __METHOD__,
            '$seeders' => $seeders,
            '$configs' => $configs,
            // '$this->seederSlugsByClass' => $this->seederSlugsByClass,
        ]);
    }

    /**
     * Prepare readme seeders
     *
     *
     * ## Seeders
     *
     * Run tag seeders
     *
     * ```shell
     * php artisan db:seed "--class=Database\Seeders\Playground\Task\Models\TagPrimarySeeder"
     * php artisan db:seed "--class=Database\Seeders\Playground\Task\Models\TagSecondarySeeder"
     * ```
     *
     * Run task seeders
     *
     * ```shell
     * php artisan db:seed "--class=Database\Seeders\Playground\Task\Models\TaskPrimarySeeder"
     * php artisan db:seed "--class=Database\Seeders\Playground\Task\Models\TaskSecondarySeeder"
     * php artisan db:seed "--class=Database\Seeders\Playground\Task\Models\TaskTertiarySeeder"
     * ```
     */
    public function prepare_seeders_for_readme(): void
    {
        $this->prepare_seeders_data();
        // $this->searches['readme_seeders'] = '';

        if (! $this->c->withSeeders()) {
            return;
        }

        $this->searches['readme_seeders'] .= '## Seeders';
        $this->searches['readme_seeders'] .= PHP_EOL;
        $this->searches['readme_seeders'] .= PHP_EOL;

        $seeders = $this->c->seeders()['seeders'] ?? [];

        foreach ($seeders as $className => $seeder) {
            if (in_array($seeder->type(), [
                'abstract-tag',
                'abstract-doublet',
                'abstract-triplet',
            ])) {
                continue;
            }

            $modelNamespace = 'Playground\Task\Models';
            $seederClass = sprintf('Database\Seeders\%1$s\%2$s', $modelNamespace, $className);
            $this->searches['readme_seeders'] .= sprintf('%1$s### Run %2$s seeder', PHP_EOL, $className);
            $this->searches['readme_seeders'] .= PHP_EOL;
            $this->searches['readme_seeders'] .= PHP_EOL.'```shell';
            $this->searches['readme_seeders'] .= sprintf(
                '%1$sphp artisan db:seed "--class=%2$s"',
                PHP_EOL,
                $seederClass
            );

            $this->searches['readme_seeders'] .= PHP_EOL.'```'.PHP_EOL;
        }
    }

    public function handle_seeders(): void
    {
        //        dump([
        //            '__METHOD__' => __METHOD__,
        //            '$this->options()' => $this->options(),
        //            // '$this->c' => $this->c->toArray(),
        //        ]);

        $seeders = $this->c->seeders()['seeders'] ?? [];

        $i = 0;
        foreach ($seeders as $className => $seeder) {

            $params = [
                'name' => $className,
                '--type' => $seeder->type(),
            ];

            if ($this->hasOption('force') && $this->option('force')) {
                $params['--force'] = true;
            }
            $seederClass = sprintf(
                '/Database/Seeders/%1$s/Models/%2$s',
                $this->c->namespace(),
                $className
            );

            $seederClassPrimary = sprintf(
                '/Database/Seeders/%1$s/Models/%2$s',
                $this->c->namespace(),
                Str::of($className)->before('Seeder')->finish('PrimarySeeder')->toString()
            );

            $seederClassSecondary = sprintf(
                '/Database/Seeders/%1$s/Models/%2$s',
                $this->c->namespace(),
                Str::of($className)->before('Seeder')->finish('SecondarySeeder')->toString()
            );

            $seederClassTertiary = sprintf(
                '/Database/Seeders/%1$s/Models/%2$s',
                $this->c->namespace(),
                Str::of($className)->before('Seeder')->finish('TertiarySeeder')->toString()
            );

            if (in_array($seeder->type(), [
                'abstract-tag',
            ])) {
                $params['--seeders'] = [
                    ...! empty($this->seederSlugsByClass[$seederClass]) ? $this->seederSlugsByClass[$seederClass] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassPrimary]) ? $this->seederSlugsByClass[$seederClassPrimary] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassSecondary]) ? $this->seederSlugsByClass[$seederClassSecondary] : [],
                ];
            } elseif (in_array($seeder->type(), [
                'abstract-doublet',
            ])) {
                $params['--seeders'] = [
                    ...! empty($this->seederSlugsByClass[$seederClass]) ? $this->seederSlugsByClass[$seederClass] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassPrimary]) ? $this->seederSlugsByClass[$seederClassPrimary] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassSecondary]) ? $this->seederSlugsByClass[$seederClassSecondary] : [],
                ];
            } elseif (in_array($seeder->type(), [
                'abstract-triplet',
            ])) {
                $params['--seeders'] = [
                    ...! empty($this->seederSlugsByClass[$seederClass]) ? $this->seederSlugsByClass[$seederClass] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassPrimary]) ? $this->seederSlugsByClass[$seederClassPrimary] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassSecondary]) ? $this->seederSlugsByClass[$seederClassSecondary] : [],
                    ...! empty($this->seederSlugsByClass[$seederClassTertiary]) ? $this->seederSlugsByClass[$seederClassTertiary] : [],
                ];
            } else {
                if (! empty($this->seederSlugsByClass[$seederClass])) {
                    $params['--seeders'] = $this->seederSlugsByClass[$seederClass];
                }
            }

            dump([
                '__METHOD__' => __METHOD__,
                '$className' => $className,
                '$seeder' => $seeder,
            ]);
            if (in_array($seeder->type(), [
                'abstract-tag',
                // 'abstract-doublet',
                // 'abstract-triplet',
            ])) {
                $params['--model'] = $seeder->model();

            } elseif (in_array($seeder->type(), [
                'abstract-triplet',
            ])) {
                $params['--model'] = $seeder->model();
                $params['--model-tag'] = $seeder->model_tag();
                $params['--model-tagged'] = $seeder->model_tagged();

            } elseif (in_array($seeder->type(), [
                'primary-tag',
                'secondary-tag',
            ])) {
                $params['--model'] = $seeder->model();
                //                dd([
                //                    '__METHOD__' => __METHOD__,
                //                    '$className' => $className,
                //                    '$params' => $params,
                //                    '$seeder' => $seeder,
                //                    '$seederClass' => $seederClass,
                //                    '$this->seederSlugsByClass' => $this->seederSlugsByClass,
                //                    '$this->seeders' => $this->seeders,
                //                    // '$model' => $model,
                //                    // '$this->c' => $this->c->toArray(),
                //                ]);
            } elseif (in_array($seeder->type(), [
                'primary-triplet',
                'secondary-triplet',
                'tertiary-triplet',
            ])) {
                $params['--model'] = $seeder->model();
                //                dd([
                //                    '__METHOD__' => __METHOD__,
                //                    '$className' => $className,
                //                    '$params' => $params,
                //                    '$seeder' => $seeder,
                //                    '$seederClass' => $seederClass,
                //                    '$this->seederSlugsByClass' => $this->seederSlugsByClass,
                //                    // '$model' => $model,
                //                    // '$this->c' => $this->c->toArray(),
                //                ]);
            } else {
                dd([
                    '__METHOD__' => __METHOD__,
                    '$className' => $className,
                    '$params' => $params,
                    '$seeder' => $seeder,
                    // '$model' => $model,
                    // '$this->c' => $this->c->toArray(),
                ]);
            }

            if ($this->c->skeleton()) {
                $params['--skeleton'] = true;
            }

            // TODO the package config is not being loaded
            if ($this->c->namespace()) {
                $params['--namespace'] = $this->c->namespace();
            }

            if ($this->c->package()) {
                $params['--package'] = $this->c->package();
            }

            if ($this->c->module()) {
                $params['--module'] = $this->c->module();
            }

            if ($this->c->recipe()) {
                $params['--recipe'] = $this->c->recipe();
            }

            dump([
                '__METHOD__' => __METHOD__,
                '$className' => $className,
                '$params' => $params,
                // '$model' => $model,
                // '$this->c' => $this->c->toArray(),
            ]);
            $this->call('playground:make:seeder', $params);
        }
    }
}
