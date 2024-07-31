<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

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

        if (in_array($type, [
            'api',
            'playground-api',
        ])) {
            $phpstan .= '-api';
        } elseif (in_array($type, [
            'resource',
            'playground-resource',
        ])) {
            $phpstan .= '-resource';
        } elseif (in_array($type, [
            'model',
            'playground-model',
        ])) {
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
                '[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%%209-brightgreen)](.github/workflows/ci.yml#L120)';
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
