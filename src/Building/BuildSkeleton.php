<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Package\Building\BuildSkeleton
 */
trait BuildSkeleton
{
    /**
     * Create the skeleton configuration
     *
     * NOTE we are checking for API and resource a few different ways here.
     * - for now support as many as possible
     */
    protected function createSkeleton(): void
    {
        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$isApi' => $isApi,
        //     '$isResource' => $isResource,
        //     '$this->options()' => $this->options(),
        //     '$this->c' => $this->c,
        // ]);

        $skeletons = [];

        $skeletons['.editorconfig'] = '.editorconfig';
        $skeletons['.gitattributes'] = '.gitattributes';
        $skeletons['gitignore'] = '.gitignore';
        $skeletons['CHANGELOG.md'] = 'CHANGELOG.md';
        $skeletons['README.md'] = 'README.md';

        $phpstan = 'phpstan.neon.dist';
        $type = $this->c->type();

        $withPhpunit = false;

        if (in_array($type, [
            'api',
            'playground-api',
        ])) {
            $withPhpunit = true;
            $phpstan .= '-api';
            $skeletons['README-API.md'] = 'README.md';
        } elseif (in_array($type, [
            'resource',
            'playground-resource',
        ])) {
            $withPhpunit = true;
            $phpstan .= '-resource';
            $skeletons['README-API.md'] = 'README.md';
        } elseif (in_array($type, [
            'model',
            'playground-model',
        ])) {
            $withPhpunit = true;
            $phpstan .= '-model';
        }

        $this->setUpLang();
        $this->setUpWorkflow();

        $skeletons[$phpstan] = 'phpstan.neon.dist';

        $this->setReadme();

        if ($this->c->package_license() === 'MIT') {
            $skeletons['LICENSE-MIT.md'] = 'LICENSE.md';
        }

        if ($withPhpunit) {
            $skeletons['phpunit-ci.xml.stub'] = 'phpunit-ci.xml';
            $skeletons['phpunit.xml.dev.stub'] = 'phpunit.xml.dev';
            $skeletons['phpunit.xml.dist.stub'] = 'phpunit.xml.dist';
        }

        if ($isApi) {
            $skeletons['.php-cs-fixer.dist-api.php'] = '.php-cs-fixer.dist.php';
        } elseif ($isResource) {
            $skeletons['.php-cs-fixer.dist-resource.php'] = '.php-cs-fixer.dist.php';
        } else {
            $skeletons['.php-cs-fixer.dist.php'] = '.php-cs-fixer.dist.php';
        }

        if ($this->c->withSwagger()) {
            $skeletons['package-docs.json'] = 'package.json';

        }

        foreach ($skeletons as $skeleton => $file) {

            $path_stub = 'package/'.$skeleton;
            $path = $this->resolveStubPath($path_stub);

            $destination = sprintf(
                '%1$s/%2$s',
                dirname($this->folder()),
                $file
            );
            $stub = $this->files->get($path);

            $this->search_and_replace($stub);

            $full_path = $this->laravel->storagePath().$destination;
            $this->files->put($full_path, $stub);

            $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
        }
    }

    protected function setPackageKeywords(): void
    {
        $gammamatrix = $this->c->playground();
        $laravel = $this->c->playground();
        $package = $this->c->package();
        $module = $this->c->module();

        if (ctype_upper($module)) {
            $module_slug = Str::of($this->c->module())->lower()->kebab()->toString();
        } else {
            $module_slug = Str::of($this->c->module())->kebab()->toString();
        }

        $package_keywords = $this->c->package_keywords();

        if ($this->c->playground() && ! in_array('playground', $package_keywords)) {
            $package_keywords[] = 'playground';
        }

        if ($gammamatrix && ! in_array('gammamatrix', $package_keywords)) {
            $package_keywords[] = 'gammamatrix';
        }

        if ($laravel && ! in_array('laravel', $package_keywords)) {
            $package_keywords[] = 'laravel';
        }

        if ($module_slug && ! in_array($module_slug, $package_keywords)) {
            $package_keywords[] = $module_slug;
        }

        $package_model = '';

        if (in_array($this->c->type(), [
            'playground-api',
        ])) {
            if ($package) {
                $package_model = Str::of($package)->before('-api')->toString();
            }
        }

        // if (in_array($this->c->type(), [
        //     'playground-resource',
        // ])) {
        //     if ($package) {
        //         $package_model = Str::of($package)->before('-resource')->toString();
        //     }
        // }

        // if ($package_model && ! in_array($package_model, $package_keywords)) {
        //     $package_keywords[] = $package_model;
        // }

        if (in_array($this->c->type(), [
            'playground-resource',
        ])) {
            if ( ! in_array('playground-blade', $package_keywords)) {
                $package_keywords[] = 'playground-blade';
            }
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c' => $this->c,
        //     '$this->options()' => $this->options(),
        //     '$package_keywords' => $package_keywords,
        //     '$package_model' => $package_model,
        //     '$package' => $package,
        // ]);

        sort($package_keywords);

        if (! $this->c->package_keywords() && $package_keywords) {
            $this->c->setOptions(['package_keywords' => $package_keywords]);
        }
    }

    protected function setPackageHomepage(): void
    {
        $package_homepage = $this->c->package_homepage();

        if (! $package_homepage && $this->c->packagist()) {
            if ($this->c->package_license() === 'MIT') {
                $package_homepage = sprintf(
                    'https://github.com/%1$s',
                    $this->c->packagist(),
                );
            }
        }

        if (! $this->c->package_homepage() && $package_homepage) {
            $this->c->setOptions(['package_homepage' => $package_homepage]);
        }
    }

    protected function setPackageAuthor(): void
    {
        $organization_email = $this->c->organization_email();
        $organization_user = '';
        $package_authors = $this->c->package_authors();

        $gammamatrix = $this->c->playground();

        if ($gammamatrix && ! $package_authors) {

            if ($organization_email) {
                $organization_user = Str::of($organization_email)->before('@')->replace('.', ' ')->title()->toString();

            }
            $package_authors[] = [
                'name' => $organization_user,
                'email' => $organization_email,
                'role' => 'Developer',
            ];

            $this->c->setOptions(['package_authors' => $package_authors]);
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_authors' => $package_authors,
        //     '$this->c' => $this->c,
        // ]);
    }

    protected function setPackageDescription(): void
    {
        $package_description = $this->c->package_description();
        $organization = $this->c->organization();
        $module = $this->c->module();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_description' => $package_description,
        //     '$this->c->organization()' => $this->c->organization(),
        //     '$this->c->module()' => $this->c->module(),
        //     '$this->c->name()' => $this->c->name(),
        // ]);

        if ($module === 'CMS') {
            $system = 'Content Management System';
        } elseif ($module === 'CRM') {
            $system = 'Client Relationship Management System';
        } elseif ($module === 'DAM') {
            $system = 'Digital Asset Management System';
        } else {
            $system = trim($module.' System');
        }

        if (! $package_description && $this->c->organization()) {
            if (in_array($this->c->type(), [
                'playground-model',
            ])) {
                $package_description = sprintf(
                    // Playground: Provide the CMS models for the Playground Content Management System.
                    '%1$s: Provide the %2$s models for the %1$s %3$s.',
                    // '%1$s: Provide the %2$s models for the %1$s %2$s System.',
                    $organization,
                    $module,
                    $system,
                );
                $package_description = __('playground-make-package::composer.model.description', [
                    'organization' => $this->c->organization(),
                    'module' => $this->c->module(),
                    'system' => $system,
                ]);
            } elseif (in_array($this->c->type(), [
                'playground-api',
            ])) {
                $package_description = __('playground-make-package::composer.api.description', [
                    'organization' => $this->c->organization(),
                    'module' => $this->c->module(),
                    'system' => $system,
                ]);
            } elseif (in_array($this->c->type(), [
                'playground-resource',
            ])) {
                $package_description = __('playground-make-package::composer.resource.description', [
                    'organization' => $this->c->organization(),
                    'module' => $this->c->module(),
                    'system' => $system,
                ]);
            }
        }

        $this->c->setOptions(['package_description' => $package_description]);
        $this->c->apply();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_description' => $package_description,
        //     '$this->c' => $this->c,
        // ]);
    }

    protected function setPackageProviders(): void
    {
        $provider = sprintf('%1$s/ServiceProvider', $this->c->namespace());

        if (! in_array($provider, $this->c->package_laravel_providers())) {
            $this->c->addClassTo('package_laravel_providers', $provider);
        }
    }

    protected function setPackageRequire(): void
    {
        $playground = $this->c->playground();
        $packagist = $this->c->packagist();
        $package_require = $this->c->package_require();
        $package_require_dev = $this->c->package_require_dev();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$package_require' => $package_require,
        //     '$package_require_dev' => $package_require_dev,
        //     // '$this->c' => $this->c,
        // ]);

        if (! $package_require && $playground) {
            if (in_array($this->c->type(), [
                'playground-api',
                'playground-model',
                'playground-resource',
            ])) {
                $package_require['php'] = '^8.2';
                $package_require['gammamatrix/playground'] = '*';
                $package_require_dev['gammamatrix/playground-test'] = '*';
            }

            if (in_array($this->c->type(), [
                'playground-resource',
            ])) {
                $package_require['gammamatrix/playground-auth'] = '*';
                $package_require['gammamatrix/playground-http'] = '*';

                $package_require_dev['gammamatrix/playground-login-blade'] = '*';
                $package_require_dev['gammamatrix/playground-site-blade'] = '*';

                $package_model = Str::of($packagist)->before('-resource')->toString();
                if ($package_model) {
                    $package_require[$package_model] = '*';
                }
            }
            if (in_array($this->c->type(), [
                'playground-api',
            ])) {
                $package_require['gammamatrix/playground-auth'] = '*';
                $package_require['gammamatrix/playground-http'] = '*';
                $package_require_dev['laravel/sanctum'] = '^4.0';

                $package_model = Str::of($packagist)->before('-api')->toString();
                if ($package_model) {
                    $package_require[$package_model] = '*';
                }
            }
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$package_require' => $package_require,
        //     '$package_require_dev' => $package_require_dev,
        //     // '$this->c' => $this->c,
        // ]);

        $this->c->setOptions([
            'package_require' => $package_require,
            'package_require_dev' => $package_require_dev,
        ]);
    }

    protected function setPackageSuggest(): void
    {
        $packagist = $this->c->packagist();
        $package_suggest = $this->c->package_suggest();

        if (! $package_suggest && $packagist) {
            if (in_array($this->c->type(), [
                'playground-model',
            ])) {
                $api = Str::of($packagist)->finish('-api')->toString();
                $resource = Str::of($packagist)->finish('-resource')->toString();
                $package_suggest[$api] = 'Provides an API, without a UI, to interact with the models provided in this package.';
                $package_suggest[$resource] = 'Provides a resource API and optional Blade UI to interact with the models provided in this package.';
            }
        }

        if (! $this->c->package_suggest() && $package_suggest) {
            $this->c->setOptions(['package_suggest' => $package_suggest]);
        }
    }

    protected function setPackageVersion(): void
    {
        if (! $this->c->version() && $this->c->skeleton()) {
            $this->c->setOptions(['version' => '1.0.0']);
        }
    }

    protected function setReadme(): void
    {
        $this->setReadmePhpStan();
        $this->setReadmeLicense();
    }

    protected function setReadmePhpStan(): void
    {
        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');

        $phpstan = [];

        $phpstan[] = '- `config/`';

        if (! $isApi && ! $isResource) {
            $phpstan[] = '- `database/`';
        } else {
            $phpstan[] = '- `lang/`';
            $phpstan[] = '- `routes/`';
        }

        $phpstan[] = '- `src/`';
        $phpstan[] = '- `tests/Feature/`';
        $phpstan[] = '- `tests/Unit/`';

        $this->searches['readme_phpstan'] = implode(PHP_EOL, $phpstan);
    }

    protected function setReadmeLicense(): void
    {
        $this->searches['readme_license'] = '';

        if ($this->c->package_license() !== 'MIT') {
            return;
        }

        $this->searches['readme_license'] = <<<'PHP_CODE'

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

PHP_CODE;
    }
}
