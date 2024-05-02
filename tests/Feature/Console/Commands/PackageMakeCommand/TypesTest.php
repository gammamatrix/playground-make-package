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
 * \Tests\Feature\Playground\Make\Package\Console\Commands\PackageMakeCommand\TypesTest
 */
#[CoversClass(PackageMakeCommand::class)]
class TypesTest extends TestCase
{
    public function test_command_make_package_with_force_and_with_playground_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --type playground --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --type playground --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_type_without_file(): void
    {
        $command = 'playground:make:package testing --force --type playground';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --type playground';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_model_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --type playground-model --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_model_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --type playground-model --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_model_type_without_file(): void
    {
        $command = 'playground:make:package testing --force --type playground-model';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_model_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --type playground-model';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_api_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --type playground-api --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_api_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --type playground-api --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_api_type_without_file(): void
    {
        $command = 'playground:make:package testing --force --type playground-api';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_api_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --type playground-api';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_resource_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --type playground-resource --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_resource_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --type playground-resource --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_resource_type_without_file(): void
    {
        $command = 'playground:make:package testing --force --type playground-resource';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_resource_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --type playground-resource';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_api_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --type api --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_api_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --type api --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_api_type_without_file(): void
    {
        $command = 'playground:make:package testing --force --type api';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_api_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --type api';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_resource_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --type resource --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_resource_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --type resource --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_resource_type_without_file(): void
    {
        $command = 'playground:make:package testing --force --type resource';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_resource_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force --type resource';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_default_type(): void
    {
        $command = sprintf(
            'playground:make:package --force --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_default_type_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_default_type_without_file(): void
    {
        $command = 'playground:make:package testing --force';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_default_type_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:package testing --skeleton --force';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_default_type_with_policies(): void
    {
        $command = sprintf(
            'playground:make:package --force --policies --type playground-model --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_model_type_and_with_skeleton_with_policies(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --policies --type playground-model --file %1$s',
            $this->getResourceFile('test-package')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_and_with_playground_model_type_without_file_with_policies(): void
    {
        $command = 'playground:make:package testing --force --policies';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_package_with_force_with_playground_model_type_and_with_skeleton_without_file_with_policies(): void
    {
        $command = 'playground:make:package testing --skeleton --force --policies';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
