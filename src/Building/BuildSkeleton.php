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
     */
    protected function createSkeleton(): void
    {
        $skeletons = [];

        $skeletons['.editorconfig'] = '.editorconfig';
        $skeletons['.gitattributes'] = '.gitattributes';
        $skeletons['gitignore'] = '.gitignore';
        $skeletons['.php-cs-fixer.dist.php'] = '.php-cs-fixer.dist.php';
        $skeletons['CHANGELOG.md'] = 'CHANGELOG.md';

        $phpstan = 'phpstan.neon.dist';
        $type = $this->c->type();

        $withPhpunit = false;

        if (in_array($type, [
            'api',
            'playground-api',
        ])) {
            $withPhpunit = true;
            $phpstan .= '-api';
        } elseif (in_array($type, [
            'resource',
            'playground-resource',
        ])) {
            $withPhpunit = true;
            $phpstan .= '-resource';
        } elseif (in_array($type, [
            'model',
            'playground-model',
        ])) {
            $withPhpunit = true;
            $phpstan .= '-model';
        }

        $this->setUpWorkflow();

        $skeletons[$phpstan] = 'phpstan.neon.dist';

        if ($this->c->package_license() === 'MIT') {
            $skeletons['LICENSE-MIT.md'] = 'LICENSE.md';
            $skeletons['README-MIT.md'] = 'README.md';
        } else {
            $skeletons['README.md'] = 'README.md';
        }

        if ($withPhpunit) {
            $skeletons['phpunit-ci.xml.stub'] = 'phpunit-ci.xml';
            $skeletons['phpunit.xml.dev.stub'] = 'phpunit.xml.dev';
            $skeletons['phpunit.xml.dist.stub'] = 'phpunit.xml.dist';
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

        if (in_array($this->c->type(), [
            'playground-api',
            'playground-model',
            'playground-resource',
        ])) {
            if ($this->c->module_slug() && ! in_array($this->c->module_slug(), $package_keywords)) {
                $package_keywords[] = $this->c->module_slug();
            }
        }

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

        if (! $package_description && $this->c->organization()) {
            if (in_array($this->c->type(), [
                'playground-model',
            ])) {
                $package_description = sprintf(
                    '%1$s: Provide the %2$s models for the %1$s %2$s System.',
                    $this->c->organization(),
                    $this->c->module(),
                );
            } elseif (in_array($this->c->type(), [
                'playground-api',
            ])) {
                $package_description = sprintf(
                    '%1$s: Provides an API, without a UI for interacting with %2$s, a %1$s System for Laravel applications',
                    $this->c->organization(),
                    $this->c->module(),
                );
            } elseif (in_array($this->c->type(), [
                'playground-resource',
            ])) {
                $package_description = sprintf(
                    '%1$s: Provides an API, with a UI for interacting with %2$s, a %1$s System for Laravel applications',
                    $this->c->organization(),
                    $this->c->module(),
                );
            }
        }

        $this->c->setOptions(['package_description' => $package_description]);
        $this->c->apply();
        // dump([
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

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$provider' => $provider,
        //     '$provider' => $provider,
        //     '$this->c' => $this->c,
        // ]);
    }

    protected function setPackageRequire(): void
    {
        $playground = $this->c->playground();
        $packagist = $this->c->packagist();
        $package_require = $this->c->package_require();
        $package_require_dev = $this->c->package_require_dev();

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
                $package_model = Str::of($packagist)->before('-response')->toString();
                if ($package_model) {
                    $package_require[$package_model] = '*';
                }
            }
            if (in_array($this->c->type(), [
                'playground-api',
            ])) {
                $package_model = Str::of($packagist)->before('-api')->toString();
                if ($package_model) {
                    $package_require[$package_model] = '*';
                }
            }
        }

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

    protected bool $withCiWorkflow = true;

    protected bool $withTestCoverage = true;

    protected bool $withPhpStan = true;

    protected string $path_github = '';

    protected string $path_github_workflows = '';

    protected function setUpWorkflow_create_github(): void
    {
        $this->path_github = sprintf(
            '%1$s/.github',
            dirname($this->folder()),
        );

        $full_path_github = $this->laravel->storagePath().$this->path_github;

        if (is_dir($full_path_github)) {
            $this->components->info(sprintf('Directory [%s] already exists.', $full_path_github));

        } else {
            mkdir($full_path_github, 0755, true);
            if (is_dir($full_path_github)) {
                $this->components->info(sprintf('Directory [%s] created successfully.', $full_path_github));
            }
        }
    }

    protected function setUpWorkflow_create_github_workflows(): void
    {
        $this->path_github_workflows = sprintf(
            '%1$s/.github/workflows',
            dirname($this->folder()),
        );

        $full_path_github_workflows = $this->laravel->storagePath().$this->path_github_workflows;

        if (is_dir($full_path_github_workflows)) {
            $this->components->info(sprintf('Directory [%s] already exists.', $full_path_github_workflows));

        } else {
            mkdir($full_path_github_workflows, 0755, true);
            if (is_dir($full_path_github_workflows)) {
                $this->components->info(sprintf('Directory [%s] created successfully.', $full_path_github_workflows));
            }
        }
    }

    protected function setUpWorkflow(): void
    {
        $workflow = '';
        $this->searches['package_workflow'] = '';

        // $path_github_workflows = sprintf(
        //     '%1$s/.github/workflows',
        //     dirname($this->folder()),
        // );

        // $full_path_github_workflows = $this->laravel->storagePath().$path_github_workflows;

        if ($this->withCiWorkflow) {
            $workflow .= sprintf(
                '[![%1$s CI Workflow](https://github.com/%2$s/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/%2$s/testing/develop/testdox.txt)',
                $this->c->organization(),
                $this->c->packagist(),
            );

            $this->setUpWorkflow_create_github();
            $this->setUpWorkflow_create_github_workflows();

            // dd([
            //     '__METHOD__' => __METHOD__,
            //     // '$path_github' => $path_github,
            //     // '$full_path_github' => $full_path_github,
            //     // '$path_github_workflows' => $path_github_workflows,
            //     // '$full_path_github_workflows' => $full_path_github_workflows,
            //     // '$workflow' => $workflow,
            //     // '$this->getPackageFolder()' => $this->getPackageFolder(),
            //     // '$this->folder()' => $this->folder(),
            // ]);

            $path_stub = 'package/github/workflows/ci.yml';
            $path = $this->resolveStubPath($path_stub);

            $destination = sprintf(
                '%1$s/%2$s',
                $this->path_github_workflows,
                'ci.yml'
            );

            $stub = $this->files->get($path);

            $this->search_and_replace($stub);
            $full_path = $this->laravel->storagePath().$destination;
            $this->files->put($full_path, $stub);

            $this->components->info(sprintf('GitHub Actions CI Workflow [%s] created successfully.', $full_path));
        }

        if ($this->withTestCoverage) {
            if ($workflow) {
                $workflow .= PHP_EOL;
            }
            $workflow .= sprintf(
                '[![Test Coverage](https://raw.githubusercontent.com/%1$s/testing/develop/coverage.svg)](tests)',
                $this->c->packagist(),
            );
        }

        if ($this->withPhpStan) {
            if ($workflow) {
                $workflow .= PHP_EOL;
            }
            $workflow .=
                '[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)';
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$workflow' => $workflow,
        // ]);

        if ($workflow) {
            $this->searches['package_workflow'] = PHP_EOL.$workflow.PHP_EOL;
        }
    }
}
