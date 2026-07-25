<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Package\Building;

/**
 * \Playground\Make\Package\Building\BuildSkeletonOutput
 */
trait BuildSkeletonOutput
{
    protected string $path_output = '';

    protected string $path_github_outputGitkeep = '';

    protected function setUpOutputGitkeep_create_output(): void
    {
        $this->path_output = sprintf(
            '%1$s/output',
            dirname($this->folder()),
        );

        $full_path_output = $this->laravel->storagePath().$this->path_output;

        if (is_dir($full_path_output)) {
            $this->components->info(sprintf('Directory [%s] already exists.', $full_path_output));

        } else {
            mkdir($full_path_output, 0755, true);
            if (is_dir($full_path_output)) {
                $this->components->info(sprintf('Directory [%s] created successfully.', $full_path_output));
            }
        }
    }

    protected function setUpOutputGitkeep_create_output_gitkeep(): void
    {
        $this->path_github_outputGitkeep = sprintf(
            '%1$s/output/.gitkeep',
            dirname($this->folder()),
        );

        $full_path_github_outputGitkeep = $this->laravel->storagePath().$this->path_github_outputGitkeep;

        if (is_file($full_path_github_outputGitkeep)) {
            $this->components->info(sprintf('File [%s] already exists.', $full_path_github_outputGitkeep));

        } else {
            $this->files->put($full_path_github_outputGitkeep, '');
            if (is_file($full_path_github_outputGitkeep)) {
                $this->components->info(sprintf('File [%s] created successfully.', $full_path_github_outputGitkeep));
            }
        }
    }

    protected function setUpOutput(): void
    {
        $this->setUpOutputGitkeep_create_output();
        $this->setUpOutputGitkeep_create_output_gitkeep();
        $this->components->info(sprintf('Output [%s] created successfully.', $this->path_output));
    }
}
