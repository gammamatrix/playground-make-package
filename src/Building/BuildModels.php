<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Playground\Make\Configuration\Model;

/**
 * \Playground\Make\Package\Building\BuildModels
 */
trait BuildModels
{
    public function command_models(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$his->option(license)' => $this->option('license'),
        //     '$models' => $models,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->models() as $model => $file) {
            if (is_string($file) && $file) {
                $params['--file'] = $file;

                if ($this->c->skeleton()) {
                    $params['--skeleton'] = true;
                }

                $this->call('playground:make:model', $params);
            }
        }
    }

    protected function make_published_models(): void
    {
        $this->searches['publish_migrations'] = '';

        $migrations = [];

        foreach ($this->c->models() as $name => $file) {
            $model = new Model($this->readJsonFileAsArray($file));
            $migration = $model->create()?->migration();
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
    }
}
