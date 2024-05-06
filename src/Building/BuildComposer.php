<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * \Playground\Make\Package\Building\BuildComposer
 */
trait BuildComposer
{
    // "autoload": {
    //     "psr-4": {
    //         "GammaMatrix\\Playground\\Cms\\Api\\": "src",
    //         "GammaMatrix\\Playground\\Cms\\Api\\Database\\Factories\\": "database/factories"
    //     }
    // },

    abstract protected function setConfigurationByKey(string $key, string $value): void;

    abstract protected function isConfigurationByKeyEmpty(string $key): bool;

    /**
     * @param array<string, string> $searches
     * @param array<string, array<string, string>> $autoload
     */
    protected function make_composer_autoload(array &$searches, array &$autoload): string
    {
        $indent = '    ';

        $element = '%2$s';

        $content = '';

        if (!(empty($searches['package_require'])
            && empty($searches['package_require_dev'])
        )) {
            $element .= '%1$s%2$s';
        }

        $element .= '"autoload": {%1$s%3$s%2$s},';

        $element_psr4 = '%2$s"psr-4": {%1$s%3$s%2$s}%1$s';

        $psr4 = '';

        if (empty($searches['package_autoload'])
            && empty($autoload['psr-4'])
            && ! empty($searches['namespace'])
        ) {

            $autoload['psr-4'] = [];

            $autoload['psr-4'][addslashes(sprintf('%1$s\\', $searches['namespace']))] = 'src';

            if (! $this->isConfigurationByKeyEmpty('factories')) {
                $autoload['psr-4'][addslashes(sprintf('%1$s\Database\Factories', $searches['namespace']))] = 'database/factories';
            }
        }

        if (! empty($autoload['psr-4'])
            && is_array($autoload['psr-4'])
        ) {
            $i = 0;
            foreach ($autoload['psr-4'] as $namespace => $folder) {
                $psr4 .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                    PHP_EOL,
                    str_repeat($indent, 3),
                    $namespace,
                    $folder,
                    (count($autoload['psr-4']) - 2) >= $i ? ',' : ''
                );
                $i++;
            }
        }

        if (! empty($psr4)) {
            $content .= sprintf(
                $element_psr4,
                PHP_EOL,
                str_repeat($indent, 2),
                $psr4
            );
        }

        $searches['package_autoload'] = '';
        if (! empty($content)) {
            $searches['package_autoload'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        }

        return $searches['package_autoload'];
    }

    protected function make_composer_require(): string
    {
        $indent = '    ';

        $element = '%2$s"require": {%1$s%3$s%2$s},';

        $content = '';

        $package_require = $this->c->package_require();

        if (empty($package_require)) {
            $package_require = [
                'php' => '^8.2',
            ];
        }

        if ($this->c->playground()
            && empty($package_require['gammamatrix/playground'])
        ) {
            $package_require['gammamatrix/playground'] = 'dev-develop|dev-feature/*';
        }

        $i = 0;
        foreach ($package_require as $package => $versions) {
            $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                PHP_EOL,
                str_repeat($indent, 2),
                $package,
                $versions,
                (count($package_require) - 2) >= $i ? ',' : ''
            );
            $i++;
        }

        $this->searches['package_require'] = '';

        if (! empty($content)) {
            $this->searches['package_require'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        }

        return $this->searches['package_require'];
    }

    protected function make_composer_require_dev(): string
    {
        $indent = '    ';

        $element = '%2$s';

        if (! empty($this->searches['package_require'])) {
            $element .= '%1$s%2$s';
        }

        $element .= '"require_dev": {%1$s%3$s%2$s},';

        $content = '';

        $package_require_dev = $this->c->package_require_dev();

        if ($this->c->playground()
            && empty($package_require_dev['gammamatrix/playground-test'])
        ) {
            $package_require_dev['gammamatrix/playground-test'] = 'dev-develop|dev-feature/*';
        }

        $i = 0;
        foreach ($package_require_dev as $package => $versions) {
            $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                PHP_EOL,
                str_repeat($indent, 2),
                $package,
                $versions,
                (count($package_require_dev) - 2) >= $i ? ',' : ''
            );
            $i++;
        }

        $this->searches['package_require_dev'] = '';
        if (! empty($content)) {
            $this->searches['package_require_dev'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        }

        return $this->searches['package_require_dev'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_keywords(array &$searches): string
    {
        $indent = '    ';

        $element = '%2$s"keywords": [%1$s%3$s%2$s],';

        $content = '';

        if (empty($searches['package_keywords'])) {
            $searches['package_keywords'] = [
                'laravel',
                // 'playground',
            ];
        }

        if (! empty($searches['package_keywords'])
            && is_array($searches['package_keywords'])
        ) {
            foreach ($searches['package_keywords'] as $i => $keyword) {
                $content .= sprintf('%2$s"%3$s"%4$s%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $keyword,
                    (count($searches['package_keywords']) - 2) >= $i ? ',' : ''
                );
                // $content = trim($content, ',');
            }
        }

        $searches['package_keywords'] = '';
        if (! empty($content)) {
            $searches['package_keywords'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        }

        return $searches['package_keywords'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_packagist(array &$searches): string
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$searches[packagist]' => $searches['packagist'],
        //     '$searches' => $searches,
        // ]);

        $searches['packagist'] = '';

        if (empty($searches['packagist'])
            && ! empty($searches['package'])
        ) {
            $searches['packagist'] = sprintf(
                '%1$s/%2$s',
                Str::of($this->rootNamespace())->before('\\')->slug('-')->toString(),
                $searches['package'],
            );
        }

        if ($searches['packagist']) {
            $this->setConfigurationByKey('packagist', $searches['packagist']);
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$searches[packagist]' => $searches['packagist'],
        //     '$searches' => $searches,
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        // ]);

        return $searches['packagist'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_license(): string
    {
        $indent = '    ';

        $package_license = $this->c->package_license();

        $element = '%1$s%2$s"license": "%3$s",';

        $this->searches['package_license'] = '';

        if (! empty($package_license)) {
            $this->searches['package_license'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $package_license
            );
        }

        return $this->searches['package_license'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_homepage(array &$searches): string
    {
        $indent = '    ';

        $element = '%1$s%2$s"homepage": "%3$s",';

        $searches['package_homepage'] = '';

        if (! empty($searches['package_homepage'])
            && is_string($searches['package_homepage'])
            && filter_var($searches['package_homepage'], FILTER_VALIDATE_URL)
        ) {
            $searches['package_homepage'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $searches['package_homepage']
            );
        }

        return $searches['package_homepage'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_providers(array &$searches): string
    {
        $indent = '    ';

        $element = '%1$s%2$s%3$s%4$s';

        $content = '';

        $providers = [];

        if (empty($searches['package_laravel_providers'])) {
            $providers[] = addslashes(sprintf('%1$s\ServiceProvider', $searches['namespace']));
        } elseif (is_array($searches['package_laravel_providers'])) {
            foreach ($searches['package_laravel_providers'] as $provider) {
                if (! empty($provider) && is_string($provider)) {
                    $providers[] = addslashes($provider);
                }
            }
        }

        $i = 0;
        foreach ($providers as $provider) {
            $content .= sprintf('%2$s"%3$s"%4$s%1$s',
                PHP_EOL,
                str_repeat($indent, 3),
                $provider,
                (count($providers) - 2) >= $i ? ',' : ''
            );
            $i++;
        }

        $searches['package_laravel_providers'] = '';
        if (! empty($content)) {
            $searches['package_laravel_providers'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content,
                str_repeat($indent, 3)
            );
        }

        return $searches['package_laravel_providers'];
    }

    /**
     * Create the configuration folder for the package.
     *
     * @param array<string, string> $searches
     * @param array<string, array<string, string>> $autoload
     * @return void
     */
    protected function createComposerJson(array &$searches, array &$autoload)
    {
        $path_stub = 'package/composer.stub';
        $path = $this->resolveStubPath($path_stub);

        $stub = $this->files->get($path);

        $this->make_composer_packagist($searches);
        $this->make_composer_keywords($searches);
        $this->make_composer_license();
        $this->make_composer_homepage($searches);
        $this->make_composer_require();
        $this->make_composer_require_dev();
        $this->make_composer_autoload($searches, $autoload);
        $this->make_composer_providers($searches);

        $this->search_and_replace($stub);

        $file = 'composer.json';

        $destination = sprintf(
            '%1$s/%2$s',
            dirname($this->folder()),
            $file
        );

        $full_path = $this->laravel->storagePath().$destination;

        $this->files->put($full_path, $stub);

        $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    }
}
