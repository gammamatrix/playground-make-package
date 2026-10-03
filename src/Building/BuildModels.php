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
 * \Playground\Make\Package\Building\BuildModels
 */
trait BuildModels
{
    public function load_models(): void
    {
        $models = $this->c->models();

        foreach ($models as $model => $file) {
            if (is_string($file) && $file) {
                $this->modelFiles[$model] = $file;
                $this->models[$model] = new Model($this->readJsonFileAsArray($file))->apply();
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

        $models = $this->modelPackage?->models() ?? [];
        // dump([
        //    '__METHOD__' => __METHOD__,
        //    '$models' => $models,
        // ]);
        foreach ($models as $model => $file) {
            if (is_string($file) && $file) {
                $this->modelFiles[$model] = $file;
                $this->models[$model] = new Model($this->readJsonFileAsArray($file))->apply();
            }
        }
        //        dd([
        //            '__METHOD__' => __METHOD__,
        //            '$this->modelPackage' => $this->modelPackage,
        //        ]);
    }

    public function prepare_models_for_readme(): void
    {
        $this->searches['readme_models'] = '';

        $i = 0;
        foreach ($this->models as $modelName => $model) {

            $this->searches['readme_models'] .= sprintf(
                '%1$s- [%2$s](src/Models/%2$s.php)',
                PHP_EOL,
                $modelName
            );
            $i++;
        }

        $this->searches['readme_models_count'] = strval($i);
    }

    public function handle_models(): void
    {
        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        if ($this->hasOption('test') && $this->option('test')) {
            $params['--test'] = true;
        }

        foreach ($this->models as $modelName => $model) {
            if (! empty($this->modelFiles[$modelName])) {
                $params['--file'] = $this->modelFiles[$modelName];
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

            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$modelName' => $modelName,
            //     '$params' => $params,
            //     // '$model' => $model,
            //     // '$this->c' => $this->c->toArray(),
            // ]);
            $this->call('playground:make:model', $params);
        }
    }

    protected function prepare_readme_env_vars(): void
    {
        $package = $this->c->package();
        $this->searches['readme_model_config_dashes'] = sprintf('%1$s%2$s', str_repeat('-', strlen($package)), str_repeat('-', 20));
        $this->searches['readme_model_config_spaces'] = sprintf('%1$s%2$s', str_repeat(' ', strlen($package)), str_repeat(' ', 11));
        $this->searches['readme_model_env_dashes'] = sprintf('%1$s%2$s', str_repeat('-', strlen($package)), str_repeat('-', 20));
        $this->searches['readme_model_env_spaces'] = sprintf('%1$s%2$s', str_repeat(' ', strlen($package)), str_repeat(' ', 14));
    }

    protected function prepare_published_models(): void
    {
        $this->searches['publish_migrations'] = '';

        $migrations = [];

        foreach ($this->models as $modelName => $model) {
            // dump([
            //    '__METHOD__' => __METHOD__,
            //    '$file' => $file,
            // ]);
            $migration = $model->create()?->migration();
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$name' => $name,
            //     '$file' => $file,
            //     '$migration' => $migration,
            // ]);
            if ($migration && ! in_array($migration, $migrations)) {
                $migrations[] = $migration;
                $this->searches['publish_migrations'] .= sprintf(
                    '%1$s%2$s\'%3$s.php\',',
                    PHP_EOL,
                    str_repeat(' ', 12),
                    $migration
                );
            }
        }
        // dump([
        // '__METHOD__' => __METHOD__,
        // '$this->c->models()' => $this->c->models(),
        // '$this->searches[publish_migrations]' => $this->searches['publish_migrations'],
        // //'$this->c' => $this->c,
        // ]);
    }

    // /**
    // * @deprecated use load_model_package instead
    // */
    // public function load_packages_from_resources(): void
    // {
    //    $path = $this->getResourcePackageFolder();
    //
    //    $fullpath = $this->laravel->storagePath().$path;
    //
    //    if (! is_dir($fullpath)) {
    //        return;
    //    }
    //
    //    $models = [];
    //
    //    $listing = scandir($fullpath);
    //    if (is_array($listing)) {
    //        foreach ($listing as $model) {
    //            if (! is_dir($fullpath.'/'.$model)
    //                || in_array($model, ['.', '..'])
    //            ) {
    //                continue;
    //            }
    //
    //            $className = Str::of($model)->studly()->toString();
    //            $models[$className] = sprintf('resources/package/%1$s/model.json', $model);
    //        }
    //    }
    //
    //    if (! empty($models)) {
    //        $this->c->addModels([
    //            'models' => $models,
    //        ]);
    //        $this->c->apply();
    //    }
    //     dump([
    //        '__METHOD__' => __METHOD__,
    //        '$this->c->models()' => $this->c->models(),
    //        '$this->getPackageFolder()' => $this->getPackageFolder(),
    //        '$this->getResourcePackageFolder()' => $this->getResourcePackageFolder(),
    //        '$path' => $path,
    //        '$fullpath' => $fullpath,
    //        '$models' => $models,
    //        '$listing' => $listing,
    //     ]);
    // }
}
