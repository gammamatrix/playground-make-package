<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Package\Building\BuildConfig
 */
trait BuildConfig
{
    /**
     * Create the configuration folder for the package.
     */
    protected function createConfig(): void
    {
        if (! $this->c->config()
            || ! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $this->c->config())
        ) {
            // Only create a config file if a valid filename is provided.
            $this->components->info('Skipping config file.');

            return;
        }

        $config_space = $this->c->config_space();

        if (! $config_space) {
            $config_space = Str::of($this->c->namespace())
                ->upper()
                ->trim('/')
                ->trim('\\')
                ->replace('/', '_')
                ->replace('\\', '_')
                ->toString();

            $this->c->setOptions([
                'config_space' => $config_space,
            ]);
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->config_space()' => $this->c->config_space(),
        // ]);
        $this->searches['config_space'] = $config_space;

        $path_stub = 'config/default.stub';

        $type = $this->c->type();

        if (in_array($type, [
            'model',
            'playground-model',
        ])) {
            $path_stub = 'config/playground-model.stub';
        } elseif (in_array($type, [
            'api',
            'playground-api',
        ])) {
            $path_stub = 'config/playground-api.stub';
        } elseif (in_array($type, [
            'resource',
            'playground-resource',
        ])) {
            $path_stub = 'config/playground-resource.stub';
        }

        $path = $this->resolveStubPath($path_stub);

        $file = sprintf(
            'config/%1$s.php',
            $this->c->config()
        );

        $destination = sprintf(
            '%1$s/%2$s',
            dirname($this->folder()),
            $file
        );

        $stub = $this->files->get($path);

        $this->search_and_replace($stub);

        $full_path = $this->laravel->storagePath().$destination;

        $this->makeDirectory($full_path);

        $this->files->put($full_path, $stub);

        $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    }
}
