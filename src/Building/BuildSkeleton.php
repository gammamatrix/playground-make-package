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
     *
     * @param array<string, string> $searches
     */
    protected function createSkeleton(array &$searches): void
    {
        $skeletons = [];

        $skeletons['.editorconfig'] = '.editorconfig';
        $skeletons['.gitattributes'] = '.gitattributes';
        $skeletons['gitignore'] = '.gitignore';
        $skeletons['.php-cs-fixer.dist.php'] = '.php-cs-fixer.dist.php';
        $skeletons['CHANGELOG.md'] = 'CHANGELOG.md';

        if ($this->c->package_license() === 'MIT') {
            $skeletons['LICENSE-MIT.md'] = 'LICENSE.md';
            $skeletons['README-MIT.md'] = 'README.md';
        } else {
            $skeletons['README.md'] = 'README.md';
        }

        // $destinationPath = $this->getDestinationPath();

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$full_path' => $full_path,
        //     'dirname($full_path)' => dirname($full_path),
        //     '$path' => $path,
        //     '$destination' => $destination,
        //     '$this->folder' => $this->folder,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     // '$stub' => $stub,
        //     // '$destination' => $destination,
        //     // '$searches' => $searches,
        //     '$this->rootNamespace()' => $this->rootNamespace(),
        // ]);

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
}
