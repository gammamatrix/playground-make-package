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
 * \Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand\ApiTest
 */
#[CoversClass(PackageMakeCommand::class)]
class ApiTest extends TestCase
{
    public function test_command_make_api_package_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --force --file %1$s',
            $this->getResourceFile('test-package-api')
        );
        // dump($command);

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_api_package_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --file %1$s',
            $this->getResourceFile('test-package-api')
        );
        // dump($command);

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
