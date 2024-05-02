<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Package\Console\Commands\PackageMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Make\Package\TestCase;
use Playground\Make\Package\Console\Commands\PackageMakeCommand;

/**
 * \Tests\Unit\Playground\Make\Package\Console\Commands\PackageMakeCommand
 */
#[CoversClass(PackageMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_displays_help(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:package --help');
        $result->assertExitCode(0);
    }
}
