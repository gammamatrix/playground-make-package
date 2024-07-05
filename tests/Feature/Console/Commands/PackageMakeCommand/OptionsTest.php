<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Make\Package\Console\Commands\PackageMakeCommand;
use Tests\Feature\Playground\Make\Package\TestCase;

/**
 * \Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand\OptionsTest
 */
#[CoversClass(PackageMakeCommand::class)]
class OptionsTest extends TestCase
{
    public function test_command_make_package_with_force_and_with_factories(): void
    {
        $command = sprintf(
            'playground:make:package --force --factories --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_factories_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --factories --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_factories_without_file(): void
    {
        $command = 'playground:make:package testing --force --factories';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_factories_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --factories';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_policies(): void
    {
        $command = sprintf(
            'playground:make:package --force --policies --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_policies_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --policies --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_policies_without_file(): void
    {
        $command = 'playground:make:package testing --force --policies';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_policies_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --policies';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_controllers(): void
    {
        $command = sprintf(
            'playground:make:package --force --controllers --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_controllers_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --controllers --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_controllers_without_file(): void
    {
        $command = 'playground:make:package testing --force --controllers';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_controllers_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --controllers';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_migrations(): void
    {
        $command = sprintf(
            'playground:make:package --force --migrations --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_migrations_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --migrations --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_migrations_without_file(): void
    {
        $command = 'playground:make:package testing --force --migrations';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_migrations_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --migrations';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_models(): void
    {
        $command = sprintf(
            'playground:make:package --force --models --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_models_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --models --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_models_without_file(): void
    {
        $command = 'playground:make:package testing --force --models';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_models_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --models';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_license(): void
    {
        $command = sprintf(
            'playground:make:package --force --license MIT --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_license_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --license MIT --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_license_without_file(): void
    {
        $command = 'playground:make:package testing --force --license private';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_license_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --license private';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
