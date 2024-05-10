<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Package\Configuration\Package;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Make\Package\TestCase;
use Playground\Make\Package\Configuration\Package;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

/**
 * \Tests\Unit\Playground\Make\Package\Configuration\Package\InstanceTest
 */
#[CoversClass(Package::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => 'ServiceProvider',
        'config' => '',
        'config_space' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'withControllers' => false,
        'withFactories' => false,
        'withMigrations' => false,
        'withModels' => false,
        'withPolicies' => false,
        'withRequests' => false,
        'withRoutes' => false,
        'withSwagger' => false,
        'withTests' => false,
        'playground' => false,
        'package_name' => '',
        'package_description' => '',
        'package_homepage' => '',
        'package_keywords' => [],
        'package_license' => '',
        'package_require' => [],
        'package_require_dev' => [],
        'package_autoload_psr4' => [],
        'package_laravel_providers' => [],
        'packagist' => '',
        'controllers' => [],
        'models' => [],
        'policies' => [],
        'requests' => [],
        'routes' => [],
        'transformers' => [],
        'service_provider' => '',
        'use' => '',
        'type' => '',
        'version' => '',
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Package;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_package_for_model_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('test-package-model');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        $instance = new Package($options, true);

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$instance' => $instance->toArray(),
        //     // '$options' => $options,
        // ]);
        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-cms', $instance->package());
        $this->assertSame('gammamatrix/playground-cms', $instance->packagist());
        $this->assertSame('Cms', $instance->module());
        $this->assertSame('cms', $instance->module_slug());
        $this->assertSame('Playground/Cms/ServiceProvider', $instance->fqdn());
        $this->assertSame('Playground/Cms', $instance->namespace());
        $this->assertSame('Playground/Cms/ServiceProvider', $instance->name());
        $this->assertSame('ServiceProvider', $instance->class());
        $this->assertSame('playground-model', $instance->type());
        $this->assertSame('playground', $instance->service_provider());
        $this->assertSame([
            'laravel',
            'playground',
            'cms',
        ], $instance->package_keywords());
        $this->assertSame([
            'php' => '^8.2',
        ], $instance->package_require());
        $this->assertSame([], $instance->package_require_dev());
        // $this->assertSame([], $instance->package_autoload_psr4());
        $this->assertSame([
            'Playground/Cms/ServiceProvider',
        ], $instance->package_laravel_providers());
        $this->assertSame([], $instance->controllers());
        $this->assertSame([
            'Page' => 'resources/configurations/playground-cms/model.page.json',
            'Snippet' => 'resources/configurations/playground-cms/model.snippet.json',
            'PageRevision' => 'resources/configurations/playground-cms/model.page-revision.json',
            'SnippetRevision' => 'resources/configurations/playground-cms/model.snippet-revision.json',
        ], $instance->models());
        $this->assertSame([], $instance->policies());
        $this->assertSame([], $instance->routes());
        $this->assertFalse($instance->withControllers());
        $this->assertFalse($instance->withFactories());
        $this->assertFalse($instance->withMigrations());
        $this->assertFalse($instance->withModels());
        $this->assertFalse($instance->withPolicies());
    }

    public function test_package_for_api_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('test-package-api');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Package($options, true);

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-cms-api', $instance->package());
        $this->assertSame('gammamatrix/playground-cms-api', $instance->packagist());
        $this->assertSame('Cms', $instance->module());
        $this->assertSame('cms', $instance->module_slug());
        $this->assertSame('Playground\\Cms\\Api\\ServiceProvider', $instance->fqdn());
        $this->assertSame('Playground\\Cms\\Api', $instance->namespace());
        $this->assertSame('Playground\\Cms\\Api\\ServiceProvider', $instance->name());
        $this->assertSame('ServiceProvider', $instance->class());
        $this->assertSame('playground-api', $instance->type());
        $this->assertSame('playground-policies', $instance->service_provider());
        $this->assertSame([
            'laravel',
            'playground',
            'cms',
            'api',
        ], $instance->package_keywords());
        $this->assertSame([
            'php' => '^8.2',
        ], $instance->package_require());
        $this->assertSame([
            'playground-test' => '^73.0',
        ], $instance->package_require_dev());
        // $this->assertSame([], $instance->package_autoload_psr4());
        $this->assertSame([
            'Playground\\Cms\\Api\\ServiceProvider',
        ], $instance->package_laravel_providers());
        $this->assertSame([
            'vendor/gammamatrix/playground-make/resources/configurations/playground-cms-api/controller.page.json',
        ], $instance->controllers());
        $this->assertSame([
            'Page' => 'resources/configurations/playground-cms/model.page.json',
            'Snippet' => 'resources/configurations/playground-cms/model.snippet.json',
            'PageRevision' => 'resources/configurations/playground-cms/model.page-revision.json',
            'SnippetRevision' => 'resources/configurations/playground-cms/model.snippet-revision.json',
        ], $instance->models());
        $this->assertSame([
            'vendor/gammamatrix/playground-make/resources/configurations/playground-cms-api/policy.page.json',
            'vendor/gammamatrix/playground-make/resources/configurations/playground-cms-api/policy.snippet.json',
        ], $instance->policies());
        $this->assertSame([
            'vendor/gammamatrix/playground-make/resources/configurations/playground-cms-api/route.snippet.json',
        ], $instance->routes());
        $this->assertFalse($instance->withControllers());
        $this->assertFalse($instance->withFactories());
        $this->assertFalse($instance->withMigrations());
        $this->assertFalse($instance->withModels());
        $this->assertFalse($instance->withPolicies());
    }

    public function test_addKeyword_with_invalid_keyword_and_log_message(): void
    {
        $log = LogFake::bind();

        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
        $keyword = '';
        $instance->addKeyword($keyword);
        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());

        // $log->dump();
        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-make-package::configuration.keywords.required', [
                    'keyword' => '',
                ])
            )
        );
    }

    public function test_addRequire_with_invalid_package_and_log_message(): void
    {
        $log = LogFake::bind();

        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
        $package = '';
        $version = 'dev-master';
        $instance->addRequire($package, $version);
        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());

        // $log->dump();
        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-make-package::configuration.require.package.required', [
                    'package' => '',
                    'version' => 'dev-master',
                ])
            )
        );
    }

    public function test_addRequire_with_invalid_version_and_log_message(): void
    {
        $log = LogFake::bind();

        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
        $package = 'some-package';
        $version = '';
        $instance->addRequire($package, $version);
        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());

        // $log->dump();
        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-make-package::configuration.require.version.required', [
                    'package' => 'some-package',
                    'version' => '',
                ])
            )
        );
    }

    public function test_addRequireDev_with_invalid_package_and_log_message(): void
    {
        $log = LogFake::bind();

        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
        $package = '';
        $version = 'dev-master';
        $instance->addRequireDev($package, $version);
        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());

        // $log->dump();
        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-make-package::configuration.require-dev.package.required', [
                    'package' => '',
                    'version' => 'dev-master',
                ])
            )
        );
    }

    public function test_addRequireDev_with_invalid_version_and_log_message(): void
    {
        $log = LogFake::bind();

        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
        $package = 'some-package';
        $version = '';
        $instance->addRequireDev($package, $version);
        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());

        // $log->dump();
        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-make-package::configuration.require-dev.version.required', [
                    'package' => 'some-package',
                    'version' => '',
                ])
            )
        );
    }
}
