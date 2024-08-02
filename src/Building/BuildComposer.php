<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Package\Building\BuildComposer
 */
trait BuildComposer
{
    protected function make_composer_autoload(): string
    {
        $this->autoload['psr-4'] = [];

        $element = '%2$s';
        $element = '';

        $content = '';

        if (! (empty($this->searches['package_require'])
            && empty($this->searches['package_require_dev'])
        )) {
            $element .= '%1$s%2$s';
        }

        $element .= '"autoload": {%1$s%3$s%2$s},';

        $element_psr4 = '%2$s"psr-4": {%1$s%3$s%2$s}%1$s';

        $psr4 = '';

        if ($this->c->withFactories()) {
            $this->autoload['psr-4'][addslashes(sprintf('Database\\Factories\\%1$s\\Models\\', $this->searches['namespace']))] = 'database/factories';
        }

        if ($this->c->class() === 'ServiceProvider') {
            $this->autoload['psr-4'][addslashes(sprintf('%1$s\\', $this->searches['namespace']))] = 'src';
        }

        if (! empty($this->autoload['psr-4'])
            && is_array($this->autoload['psr-4'])
        ) {
            $i = 0;
            foreach ($this->autoload['psr-4'] as $namespace => $folder) {
                $psr4 .= sprintf('%2$s"%3$s": "%4$s/"%5$s%1$s',
                    PHP_EOL,
                    str_repeat(static::INDENT, 3),
                    $namespace,
                    $folder,
                    (count($this->autoload['psr-4']) - 2) >= $i ? ',' : ''
                );
                $i++;
            }
        }

        if (! empty($psr4)) {
            $content .= sprintf(
                $element_psr4,
                PHP_EOL,
                str_repeat(static::INDENT, 2),
                $psr4
            );
        }

        $this->searches['package_autoload'] = '';
        if (! empty($content)) {
            $this->searches['package_autoload'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $content
            );
        }

        return $this->searches['package_autoload'];
    }

    protected function make_composer_autoload_dev(): string
    {
        $this->autoload['dev-psr-4'] = [];

        $element = '%2$s';
        $element = '';

        $content = '';

        if (! (empty($this->searches['package_require'])
            && empty($this->searches['package_require_dev'])
        )) {
            // $element .= '%1$s%2$s';
            $element .= '%1$s%2$s';
        }

        $element .= '"autoload-dev": {%1$s%3$s%2$s},';

        $element_psr4 = '%2$s"psr-4": {%1$s%3$s%2$s}%1$s';

        $psr4 = '';

        if ($this->c->withTests()) {
            $this->autoload['dev-psr-4'][addslashes(sprintf('Tests\\Feature\\%1$s\\', $this->searches['namespace']))] = 'tests/Feature';
            $this->autoload['dev-psr-4'][addslashes(sprintf('Tests\\Unit\\%1$s\\', $this->searches['namespace']))] = 'tests/Unit';
        }

        if (! empty($this->autoload['dev-psr-4'])
            && is_array($this->autoload['dev-psr-4'])
        ) {
            $i = 0;
            foreach ($this->autoload['dev-psr-4'] as $namespace => $folder) {
                $psr4 .= sprintf('%2$s"%3$s": "%4$s/"%5$s%1$s',
                    PHP_EOL,
                    str_repeat(static::INDENT, 3),
                    $namespace,
                    $folder,
                    (count($this->autoload['dev-psr-4']) - 2) >= $i ? ',' : ''
                );
                $i++;
            }
        }

        if (! empty($psr4)) {
            $content .= sprintf(
                $element_psr4,
                PHP_EOL,
                str_repeat(static::INDENT, 2),
                $psr4
            );
        }

        $this->searches['package_autoload_dev'] = '';
        if (! empty($content)) {
            $this->searches['package_autoload_dev'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $content
            );
        }

        return $this->searches['package_autoload_dev'];
    }

    protected function make_composer_require(): string
    {
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
            $package_require['gammamatrix/playground'] = '*';
        }

        $i = 0;
        foreach ($package_require as $package => $versions) {
            $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                PHP_EOL,
                str_repeat(static::INDENT, 2),
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
                str_repeat(static::INDENT, 1),
                $content
            );
        }

        return $this->searches['package_require'];
    }

    protected function make_composer_require_dev(): string
    {
        $element = '%2$s';
        $element = '';

        if (! empty($this->searches['package_require'])) {
            $element .= '%1$s%2$s';
        }

        $element .= '"require-dev": {%1$s%3$s%2$s},';

        $content = '';

        $package_require_dev = $this->c->package_require_dev();

        if ($this->c->playground()
            && empty($package_require_dev['gammamatrix/playground-test'])
        ) {
            $package_require_dev['gammamatrix/playground-test'] = '*';
        }

        $i = 0;
        foreach ($package_require_dev as $package => $versions) {
            $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                PHP_EOL,
                str_repeat(static::INDENT, 2),
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
                str_repeat(static::INDENT, 1),
                $content
            );
        }

        return $this->searches['package_require_dev'];
    }

    protected function make_composer_suggest(): string
    {
        $element = '%2$s"suggest": {%1$s%3$s%2$s},';

        $content = '';

        $package_suggest = $this->c->package_suggest();

        $i = 0;
        foreach ($package_suggest as $package => $versions) {
            $content .= sprintf('%2$s"%3$s": "%4$s"%5$s%1$s',
                PHP_EOL,
                str_repeat(static::INDENT, 2),
                $package,
                $versions,
                (count($package_suggest) - 2) >= $i ? ',' : ''
            );
            $i++;
        }

        $this->searches['package_suggest'] = '';

        if (! empty($content)) {
            $this->searches['package_suggest'] = PHP_EOL.sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $content
            );
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches[package_suggest]' => $this->searches['package_suggest'],
        //     '$package_suggest' => $package_suggest,
        // ]);

        return $this->searches['package_suggest'];
    }

    protected function make_composer_keywords(): string
    {
        $package_keywords = $this->c->package_keywords();

        $element = '%2$s"keywords": [%1$s%3$s%2$s],';

        $content = '';

        foreach ($package_keywords as $i => $keyword) {
            $content .= sprintf('%2$s"%3$s"%4$s%1$s',
                PHP_EOL,
                str_repeat(static::INDENT, 2),
                $keyword,
                (count($package_keywords) - 2) >= $i ? ',' : ''
            );
        }

        $this->searches['package_keywords'] = '';
        if (! empty($content)) {
            $this->searches['package_keywords'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $content
            );
        }

        return $this->searches['package_keywords'];
    }

    protected function make_composer_package_name(): string
    {
        $package_name = $this->c->package_name();
        $package = $this->c->package();

        if (! $package_name && $package) {
            $package_name = sprintf(
                '%1$s%2$s%3$s',
                $this->c->organization(),
                $this->c->organization() ? ': ' : '',
                $this->c->name(),
            );
            $this->c->setOptions(['package_name' => $package_name]);
            $this->searches['package_name'] = $this->c->package_name();
        }

        return $this->searches['package_name'];
    }

    protected function make_composer_packagist(): string
    {
        $packagist = $this->c->packagist();
        $package = $this->c->package();

        if (! $packagist && $package) {
            $packagist = sprintf(
                '%1$s/%2$s',
                Str::of($this->rootNamespace())->before('\\')->slug('-')->toString(),
                $package,
            );
            $this->c->setOptions(['packagist' => $packagist]);
            $this->searches['packagist'] = $this->c->packagist();
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->packagist()' => $this->c->packagist(),
        // ]);

        return $this->searches['packagist'];
    }

    protected function make_composer_license(): string
    {
        $package_license = $this->c->package_license();

        $element = '%1$s%2$s"license": "%3$s",';

        $this->searches['package_license'] = '';

        if (! empty($package_license)) {
            $this->searches['package_license'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $package_license
            );
        }

        return $this->searches['package_license'];
    }

    protected function make_composer_authors(): string
    {
        $element = '%2$s"authors": [%3$s%1$s%2$s],';

        $content = '';

        $package_authors = $this->c->package_authors();

        for ($i = 0; $i < count($package_authors); $i++) {

            $author = '';

            if (! empty($package_authors[$i]['name'])) {
                $author .= sprintf('%1$s%2$s"name": "%3$s",',
                    PHP_EOL,
                    str_repeat(static::INDENT, 3),
                    $package_authors[$i]['name'],
                );
            }

            if (! empty($package_authors[$i]['email'])) {
                $author .= sprintf('%1$s%2$s"email": "%3$s",',
                    PHP_EOL,
                    str_repeat(static::INDENT, 3),
                    $package_authors[$i]['email'],
                );
            }

            if (! empty($package_authors[$i]['role'])) {
                $author .= sprintf('%1$s%2$s"role": "%3$s",',
                    PHP_EOL,
                    str_repeat(static::INDENT, 3),
                    $package_authors[$i]['role'],
                );
            }
            if ($author) {
                $author = rtrim($author, ',');
                $content .= sprintf('%1$s%2$s{%3$s%4$s%1$s%2$s}',
                    PHP_EOL,
                    str_repeat(static::INDENT, 2),
                    $author,
                    (count($package_authors) - 2) >= $i ? ',' : ''
                );
            }

            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$i' => $i,
            //     '$author' => $author,
            //     '$content' => $content,
            //     '$package_authors[$i]' => $package_authors[$i],
            // ]);
        }

        $this->searches['package_authors'] = '';

        if (! empty($content)) {
            $this->searches['package_authors'] = PHP_EOL.sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $content
            );
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_authors' => $package_authors,
        //     '$this->searches[package_authors]' => $this->searches['package_authors'],
        // ]);

        return $this->searches['package_suggest'];
    }

    protected function make_composer_homepage(): string
    {
        $package_homepage = $this->c->package_homepage();

        $element = '%1$s%2$s"homepage": "%3$s",';

        $this->searches['package_homepage'] = '';

        if ($package_homepage
            && filter_var($package_homepage, FILTER_VALIDATE_URL)
        ) {
            $this->searches['package_homepage'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $package_homepage
            );
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        // ]);

        return $this->searches['package_homepage'];
    }

    protected function make_composer_providers(): string
    {
        $package_laravel_providers = $this->c->package_laravel_providers();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_laravel_providers' => $package_laravel_providers,
        //     // '$this->c' => $this->c,
        //     // '$this->searches' => $this->searches,
        // ]);

        $this->searches['package_laravel_providers'] = '';

        $element = '%1$s%2$s%3$s%4$s';

        $content = '';

        $providers = [];

        // if (! $package_laravel_providers) {
        //     $providers[] = addslashes(sprintf('%1$s\ServiceProvider', $this->searches['namespace']));
        // } else {
        foreach ($package_laravel_providers as $provider) {
            if (! empty($provider) && is_string($provider)) {
                $providers[] = addslashes($this->parseClassInput($provider));
            }
        }
        // }

        $i = 0;
        foreach ($providers as $provider) {
            $content .= sprintf('%2$s"%3$s"%4$s%1$s',
                PHP_EOL,
                str_repeat(static::INDENT, 3),
                $provider,
                (count($providers) - 2) >= $i ? ',' : ''
            );
            $i++;
        }

        if (! empty($content)) {
            $this->searches['package_laravel_providers'] = sprintf(
                $element,
                PHP_EOL,
                str_repeat(static::INDENT, 1),
                $content,
                str_repeat(static::INDENT, 3)
            );
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_laravel_providers' => $package_laravel_providers,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        // ]);
        return $this->searches['package_laravel_providers'];
    }

    /**
     * Create the configuration folder for the package.
     */
    protected function createComposerJson(): void
    {
        $path_stub = 'package/composer.stub';
        $path = $this->resolveStubPath($path_stub);

        $stub = $this->files->get($path);

        // $this->make_composer_package_name();
        $this->make_composer_packagist();
        $this->make_composer_keywords();
        $this->make_composer_license();
        $this->make_composer_authors();
        $this->make_composer_homepage();
        $this->make_composer_require();
        $this->make_composer_require_dev();
        $this->make_composer_suggest();
        $this->make_composer_autoload();
        $this->make_composer_autoload_dev();
        $this->make_composer_providers();

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
