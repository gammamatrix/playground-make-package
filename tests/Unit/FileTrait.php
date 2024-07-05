<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Package;

/**
 * \Tests\Unit\Playground\Make\Package\FileTrait
 */
trait FileTrait
{
    /**
     * @return array<mixed>
     */
    protected function getResourceFileAsArray(string $type = ''): array
    {
        $file = $this->getResourceFile($type);
        // dump($file);
        $content = file_exists($file) ? file_get_contents($file) : null;
        $data = $content ? json_decode($content, true) : [];
        return is_array($data) ? $data : [];
    }

    protected function getResourceFile(string $type = ''): string
    {
        $package_base = dirname(dirname(__DIR__));

        if (in_array($type, [
            'test-package-model',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/package.playground-cms.json',
                $package_base
            );

        } elseif (in_array($type, [
            'test-model',
            'model-rocket',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/model.rocket.json',
                $package_base
            );

        } elseif (in_array($type, [
            'test-package',
            'test-package-api',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/package.playground-cms-api.json',
                $package_base
            );

        } elseif (in_array($type, [
            'test-package-resource',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/package.acme-demo-resource.json',
                $package_base
            );

        } else {
            $file = sprintf(
                '%1$s/resources/testing/empty.json',
                $package_base
            );
        }

        return $file;
    }
}
