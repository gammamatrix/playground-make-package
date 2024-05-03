<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Package\Building;
// use Symfony\Component\Console\Input\InputArgument;
use Playground\Make\Package\Configuration\Package as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Make\Package\Console\Commands\PackageMakeCommand
 */
#[AsCommand(name: 'playground:make:package')]
class PackageMakeCommand extends GeneratorCommand
{
    use Building\BuildComposer;
    use Building\BuildConfig;
    use Building\BuildSkeleton;
    use Building\MakeCommands;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    const SEARCH = [
        'class' => 'ServiceProvider',
        'module' => '',
        'module_slug' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'package_name' => '',
        'package_autoload' => '',
        'package_description' => '',
        'package_keywords' => '',
        'package_homepage' => '',
        'package_license' => '',
        'package_require' => '',
        'package_require_dev' => '',
        'package_autoload_psr4' => '',
        'package_laravel_providers' => '',
        'packagist' => '',
        'policies' => '',
        'routes' => '',
        'version' => '1.0.0',
    ];

    protected string $path_destination_folder = 'src';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a package';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Package';

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'api',
        'policies',
        'resource',
        'playground',
        'playground-api',
        'playground-resource',
    ];

    /**
     * Autoloading for the package.
     *
     * @var array<string, array<string, string>>
     */
    protected array $autoload = [
        'psr-4' => [],
    ];

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['controllers', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have controllers.'];
        $options[] = ['factories', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model factories.'];
        $options[] = ['migrations', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model migrations.'];
        $options[] = ['models', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have models.'];
        $options[] = ['policies', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model policies.'];
        $options[] = ['license', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' license.'];

        return $options;
    }

    public function prepareOptions(): void
    {
        // if ($this->hasOption('factories')
        //     && $this->option('factories')
        // ) {
        //     $this->c->setOptions([
        //         'factories' => true,
        //     ]);
        // }

        if ($this->hasOption('license')
            && is_string($this->option('license'))
            && $this->option('license')
        ) {
            $this->c->setOptions([
                'package_license' => $this->option('license'),
            ]);
            $this->searches['package_license'] = $this->c->package_license();
        }

        if ($this->hasOption('controllers') && $this->option('controllers')) {
            $this->c->setOptions([
                'withControllers' => true,
            ]);
        }

        if ($this->hasOption('factories') && $this->option('factories')) {
            $this->c->setOptions([
                'withFactories' => true,
            ]);
        }

        if ($this->hasOption('migrations') && $this->option('migrations')) {
            $this->c->setOptions([
                'withMigrations' => true,
            ]);
        }

        if ($this->hasOption('models') && $this->option('models')) {
            $this->c->setOptions([
                'withModels' => true,
            ]);
        }

        if ($this->hasOption('policies') && $this->option('policies')) {
            $this->c->setOptions([
                'withPolicies' => true,
            ]);
        }
    }

    public function finish(): ?bool
    {
        $this->createComposerJson($this->searches, $this->autoload);
        $this->createConfig($this->searches);
        $this->createSkeleton($this->searches);

        // $this->handle_models();
        // $this->handle_policies();
        // $this->handle_requests();
        $this->handle_controllers();

        $this->saveConfiguration();

        return $this->return_status;
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s.%2$s.json',
            Str::of($this->getType())->kebab(),
            Str::of($this->c->package())->kebab(),
        );
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $template = 'service-provider/ServiceProvider.stub';

        $type = $this->getConfigurationType();

        if (in_array($type, [
            'playground',
        ])) {
            $template = 'service-provider/ServiceProvider-playground.stub';
        } elseif (in_array($type, [
            'playground-model',
        ])) {
            $template = 'service-provider/ServiceProvider-playground-model.stub';
        } elseif (in_array($type, [
            'playground-api',
        ])) {
            $template = 'service-provider/ServiceProvider-playground-api.stub';
        } elseif (in_array($type, [
            'playground-resource',
        ])) {
            $template = 'service-provider/ServiceProvider-playground-resource.stub';
        } elseif ($this->c->policies() || in_array($type, [
            'api',
            'resource',
        ])) {
            $template = 'service-provider/ServiceProvider-policies.stub';
        }

        return $this->resolveStubPath($template);
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     */
    protected function resolveStubPath($stub): string
    {
        $path = '';
        $stub_path = config('playground-make.paths.stubs');
        if (! empty($stub_path)
            && is_string($stub_path)
        ) {
            if (! is_dir($stub_path)) {
                Log::error(__('playground-make::generator.path.invalid'), [
                    '$stub_path' => $stub_path,
                    '$stub' => $stub,
                ]);
            } else {
                $path = sprintf(
                    '%1$s/%2$s',
                    // Str::of($stub_path)->finish('/')->toString(),
                    Str::of($stub_path)->toString(),
                    $stub
                );
            }
        }

        if (empty($path)) {
            $path = sprintf(
                '%1$s/resources/stubs/%2$s',
                dirname(dirname(dirname(__DIR__))),
                $stub
            );
        }

        if (! file_exists($path)) {
            $this->components->error(__('playground-make::generator.stub.missing', [
                'stub_path' => is_string($stub_path) ? $stub_path : gettype($stub_path),
                'stub' => $stub,
                'path' => $path,
            ]));
        }

        return $path;
    }
}
