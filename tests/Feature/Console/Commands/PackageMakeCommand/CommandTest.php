<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Package\Console\Commands\PackageMakeCommand;
use Tests\Feature\Playground\Make\Package\TestCase;

/**
 * \Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand
 */
#[CoversClass(PackageMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:package');
        // $result = $this->withoutMockingConsoleOutput()->artisan('playground:make:package');
        // dd(Artisan::output());
        $result->assertExitCode(1);
        $result->expectsOutputToContain( __('playground-make::generator.input.error'));
    }

    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:package testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
