<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Package;

use Playground\Test\OrchestraTestCase;

/**
 * \Tests\Unit\Playground\Make\Package\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use FileTrait;

    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Make\ServiceProvider::class,
            \Playground\Make\Package\ServiceProvider::class,
            \Playground\Make\Controller\ServiceProvider::class,
            \Playground\Make\Factory\ServiceProvider::class,
            \Playground\Make\Migration\ServiceProvider::class,
            \Playground\Make\Policy\ServiceProvider::class,
            \Playground\Make\Request\ServiceProvider::class,
            \Playground\Make\Resource\ServiceProvider::class,
            \Playground\Make\Route\ServiceProvider::class,
            \Playground\Make\Seeder\ServiceProvider::class,
            \Playground\Make\Swagger\ServiceProvider::class,
            \Playground\Make\Template\ServiceProvider::class,
            \Playground\Make\Test\ServiceProvider::class,
        ];
    }
}
