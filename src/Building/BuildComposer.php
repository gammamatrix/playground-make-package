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

        $element = '';

        $content = '';

        if (empty($searches['package_require'])
            && empty($searches['package_require_dev'])
        ) {
            $element .= '%2$s';
        } else {
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

        if (! empty($content)) {
            $searches['package_autoload'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['package_autoload'] = '';
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$searches' => $searches,
        //     '$content' => $content,
        // ]);
        return $searches['package_autoload'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_require(array &$searches): string
    {
        $indent = '    ';

        $element = '%2$s"require": {%1$s%3$s%2$s},';

        $content = '';

        if (empty($searches['package_require'])) {
            $searches['package_require'] = [
                'php' => '^8.1',
            ];
        }

        if (! empty($searches['package_require'])
            && is_array($searches['package_require'])
        ) {
            $i = 0;
            foreach ($searches['package_require'] as $package => $versions) {
                $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $package,
                    $versions,
                    (count($searches['package_require']) - 2) >= $i ? ',' : ''
                );
                $i++;
            }
        }

        if (! empty($content)) {
            $searches['package_require'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['package_require'] = '';
        }

        return $searches['package_require'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_require_dev(array &$searches): string
    {
        $indent = '    ';

        $element = '';

        if (empty($searches['package_require'])) {
            $element .= '%2$s';
        } else {
            $element .= '%1$s%2$s';
        }

        $element .= '"require_dev": {%1$s%3$s%2$s},';

        $content = '';

        if (empty($searches['package_require_dev'])) {
            $searches['package_require_dev'] = [
                // 'php' => '^8.1',
                // 'fakerphp/faker' => '^1.9.1',
                // 'laravel/pint' => '^1.0',
                // 'laravel/sail' => '^1.18',
                // 'mockery/mockery' => '^1.4.4',
                // 'nunomaduro/collision' => '^7.0',
                // 'phpunit/phpunit' => '^10.1',
                // 'spatie/laravel-ignition' => '^2.0',
            ];
        }

        if (! empty($searches['package_require_dev'])
            && is_array($searches['package_require_dev'])
        ) {
            $i = 0;
            foreach ($searches['package_require_dev'] as $package => $versions) {
                $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $package,
                    $versions,
                    (count($searches['package_require_dev']) - 2) >= $i ? ',' : ''
                );
                $i++;
            }
        }

        if (! empty($content)) {
            $searches['package_require_dev'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['package_require_dev'] = '';
        }

        return $searches['package_require_dev'];
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

        if (! empty($content)) {
            $searches['package_keywords'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['package_keywords'] = '';
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
        if (empty($searches['packagist'])
            && ! empty($searches['package'])
        ) {
            $searches['packagist'] = sprintf(
                '%1$s/%2$s',
                Str::of($this->rootNamespace())->before('\\')->slug('-'),
                $searches['package'],
            );
        } elseif (! is_string($searches['packagist'])) {
            $searches['packagist'] = '';
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
    protected function make_composer_license(array &$searches): string
    {
        $indent = '    ';

        $element = '%1$s%2$s"license": "%3$s",';

        // if (empty($searches['package_license'])) {
        //     $searches['package_license'] = 'MIT';
        // }

        if (! empty($searches['package_license'])
            && is_string($searches['package_license'])
        ) {
            $searches['package_license'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $searches['package_license']
            );
        } else {
            $searches['package_license'] = '';
        }

        return $searches['package_license'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_composer_homepage(array &$searches): string
    {
        $indent = '    ';

        $element = '%1$s%2$s"homepage": "%3$s",';

        if (empty($searches['package_homepage'])) {
            // $searches['package_homepage'] = 'http://example.com/something';
            // $searches['package_homepage'] = 'http://example.com';
            // $searches['package_homepage'] = 'example.com';
        }

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
        } else {
            $searches['package_homepage'] = '';
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
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$searches[packagist]' => $searches['packagist'],
        //     '$searches' => $searches,
        // ]);

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

        if (! empty($content)) {
            $searches['package_laravel_providers'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat($indent, 1),
                $content,
                str_repeat($indent, 3)
            );
        } else {
            $searches['package_laravel_providers'] = '';
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$searches' => $searches,
        //     '$content' => $content,
        // ]);
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
        // $destinationPath = $this->getDestinationPath();

        $path_stub = 'package/composer.stub';
        $path = $this->resolveStubPath($path_stub);

        $stub = $this->files->get($path);

        $this->make_composer_packagist($searches);
        $this->make_composer_keywords($searches);
        $this->make_composer_license($searches);
        $this->make_composer_homepage($searches);
        $this->make_composer_require($searches);
        $this->make_composer_require_dev($searches);
        $this->make_composer_autoload($searches, $autoload);
        $this->make_composer_providers($searches);
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$searches' => $searches,
        //     '$this->c' => $this->c,
        //     '$this->folder' => $this->folder,
        // ]);

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
