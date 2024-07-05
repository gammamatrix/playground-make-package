<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Acceptance\Playground\Make\Package\Console\Commands\PackageMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Package\Console\Commands\PackageMakeCommand;
use Tests\Feature\Playground\Make\Package\TestCase;

/**
 * \Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand\ResourceTest
 */
#[CoversClass(PackageMakeCommand::class)]
class ResourceTest extends TestCase
{
    public function test_command_make_resource_package_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --force --file %1$s',
            $this->getResourceFile('test-package-resource')
        );
        // dump($command);

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_resource_package_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --file %1$s',
            $this->getResourceFile('test-package-resource')
        );
        // dump($command);

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
