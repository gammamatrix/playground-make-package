<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Package\Console\Commands;

use Illuminate\Support\Str;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Configuration\Model;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Package\Building;
use Playground\Make\Package\Configuration\Package;
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
    use Building\BuildControllers;
    use Building\BuildModels;
    use Building\BuildSeeders;
    use Building\BuildServiceProvider;
    use Building\BuildSkeleton;
    use Building\BuildSkeletonGitHub;
    use Building\BuildSkeletonLang;
    use Building\BuildSkeletonOutput;
    use Building\BuildTests;

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
        'organization_email' => '',
        'config_space' => '',
        'docs_name' => '',
        'docs_url' => '',
        'package' => '',
        'model_package' => '',
        'model_package_name' => '',
        'package_name' => '',
        'package_autoload' => '',
        'package_description' => '',
        'package_keywords' => '',
        'package_homepage' => '',
        'package_license' => '',
        'package_authors' => '',
        'package_require' => '',
        'package_require_dev' => '',
        'package_repositories' => '',
        'package_suggest' => '',
        'package_scripts' => '',
        'package_autoload_psr4' => '',
        'package_autoload_dev' => '',
        'package_laravel_providers' => '',
        'packagist' => '',
        'postman_collection' => '',
        'postman_url' => '',
        'policies' => '',
        'publish_migrations' => '',
        'recipe' => '',
        'composer_scripts' => '',
        'config_cache_docs' => '',
        'config_service_provider_routes_docs' => '',
        'config_policies' => '',
        'config_revisions' => '',
        'config_revisions_docs' => '',
        'config_routes' => '',
        'config_routes_docs' => '',
        'config_service_provider_docs_revisions' => '', // TODO implement
        'config_service_provider_docs_cache' => '', // TODO implement
        'config_abilities_manager' => '',
        'config_abilities_user' => '',
        'readme_models' => '',
        'readme_models_count' => '',
        'readme_model_config_dashes' => '                        ',
        'readme_model_config_spaces' => '---------------------------------',
        'readme_model_env_dashes' => '                                 ',
        'readme_model_env_spaces' => '-------------------------------------------',
        'readme_seeders' => '',
        'routes' => '',
        'version' => '',
        'about_routes' => '',
        'load_routes' => '',
        'lang_models_revisions' => '',
        'readme_phpstan' => '',
        'ci_phpstan_folders' => '',
        'phpstan_with_lang' => '# ',
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
        'dev-psr-4' => [],
    ];

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['blade', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have blade templates'];
        $options[] = ['controllers', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have controllers'];
        $options[] = ['covers', null, InputOption::VALUE_NONE, 'Use CoversClass for code coverage'];
        $options[] = ['factories', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model factories'];
        $options[] = ['migrations', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model migrations'];
        $options[] = ['models', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have models'];
        $options[] = ['policies', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have policies'];
        $options[] = ['requests', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have requests'];
        $options[] = ['routes', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have routes'];
        $options[] = ['license', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' license'];
        $options[] = ['email', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' organization email'];
        $options[] = ['package-version', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' version'];
        $options[] = ['packagist', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' packagist name in composer.json'];
        $options[] = ['build', null, InputOption::VALUE_NONE, 'Build the '.strtolower($this->type).' controllers, policies, requests and routes for the models'];
        $options[] = ['playground', null, InputOption::VALUE_NONE, 'Allow the '.strtolower($this->type).' to use Playground features'];
        $options[] = ['sandbox', null, InputOption::VALUE_NONE, 'Allow the '.strtolower($this->type).' to use Playground Sandbox'];
        $options[] = ['revision', null, InputOption::VALUE_NONE, 'Allow the '.strtolower($this->type).' to use revision features'];
        $options[] = ['openapi', null, InputOption::VALUE_NONE, 'Build the '.strtolower($this->type).' the OpenAPI documentation'];
        $options[] = ['seeders', null, InputOption::VALUE_NONE, 'Build the '.strtolower($this->type).' seeders'];
        $options[] = ['translations', null, InputOption::VALUE_NONE, 'Build the '.strtolower($this->type).' translations'];
        $options[] = ['test', null, InputOption::VALUE_NONE, 'Create the unit and feature tests for the '.strtolower($this->type)];
        $options[] = ['api', null, InputOption::VALUE_NONE, 'Generate an API controller class when creating the model. Requires --controllers option'];
        $options[] = ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class when creating the model. Requires --controllers option'];
        $options[] = ['model-package', null, InputOption::VALUE_OPTIONAL, 'Provide a model package configuration to import into an API or Resource package.'];
        $options[] = ['recipe', null, InputOption::VALUE_REQUIRED, 'The configuration recipe of the '.strtolower($this->type)];

        return $options;
    }

    protected ?Package $modelPackage = null;

    /**
     * @var array<string, Model>
     */
    protected array $models = [];

    /**
     * @var array<string, string>
     */
    protected array $modelFiles = [];

    public function prepareOptions(): void
    {
        // dump([
        //    '__METHOD__' => __METHOD__,
        //    '$this->options()' => $this->options(),
        // ]);
        // if ($this->hasOption('factories')
        //     && $this->option('factories')
        // ) {
        //     $this->c->setOptions([
        //         'factories' => true,
        //     ]);
        // }
        $setOptions = [];

        if ($this->hasOption('playground') && $this->option('playground')) {
            $setOptions['playground'] = true;
            $this->c->setOptions([
                'playground' => true,
            ]);
        }

        $requireConfigSpace = false;

        if ($this->c->playground() && in_array($this->c->type(), [
            'playground-api',
            'playground-model',
            'playground-resource',
        ])) {
            $requireConfigSpace = true;
        }

        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');

        if ($this->c->playground()) {
            if ($this->c->type() === 'playground-api') {
                $isApi = true;
            } elseif ($this->c->type() === 'playground-resource') {
                $isResource = true;
            }
        }

        $build = $this->hasOption('build') && $this->option('build');

        $model_package = $this->hasOption('model-package') && is_string($this->option('model-package')) ? $this->option('model-package') : '';
        if ($model_package) {
            $this->load_model_package($model_package);
        }

        if (in_array($this->c->type(), [
            'model',
            'playground-model',
        ])) {
            $this->load_models();
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->options()' => $this->options(),
        // ]);
        $config_space = null;
        if ($requireConfigSpace && ! $this->c->config_space()) {
            $config_space = Str::of($this->c->namespace())
                ->upper()
                ->trim('/')
                ->trim('\\')
                ->replace('/', '_')
                ->replace('\\', '_')
                ->toString();

            $setOptions['config_space'] = $config_space;
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->c->config_space()' => $this->c->config_space(),
        //     '$requireConfigSpace' => $requireConfigSpace,
        //     '$this->searches' => $this->searches,
        // ]);

        if ($this->hasOption('recipe')
            && is_string($this->option('recipe'))
            && $this->option('recipe')
        ) {
            $setOptions['recipe'] = $this->option('recipe');
        }

        if ($this->hasOption('packagist')
            && is_string($this->option('packagist'))
            && $this->option('packagist')
        ) {
            $setOptions['packagist'] = $this->option('packagist');
        }

        if ($this->hasOption('license')
            && is_string($this->option('license'))
            && $this->option('license')
        ) {
            $setOptions['package_license'] = $this->option('license');
        }

        if ($this->hasOption('email')
            && is_string($this->option('email'))
            && $this->option('email')
        ) {
            $setOptions['organization_email'] = $this->option('email');
        }

        if ($this->hasOption('blade') && $this->option('blade')) {
            $setOptions['withBlades'] = true;
        }

        if ($this->hasOption('controllers') && $this->option('controllers')) {
            $setOptions['withControllers'] = true;
        }

        if ($this->hasOption('factories') && $this->option('factories')) {
            $setOptions['withFactories'] = true;
        }

        if ($this->hasOption('migrations') && $this->option('migrations')) {
            $setOptions['withMigrations'] = true;
        }

        if ($this->hasOption('models') && $this->option('models')) {
            $setOptions['withModels'] = true;
        }

        if ($this->hasOption('policies') && $this->option('policies')) {
            $setOptions['withPolicies'] = true;
        }

        if ($this->hasOption('requests') && $this->option('requests')) {
            $setOptions['withRequests'] = true;
        }

        $withRoutes = false;
        if ($this->hasOption('routes') && $this->option('routes')) {
            $withRoutes = true;
            $setOptions['withRoutes'] = $withRoutes;
        }

        if ($withRoutes) {
            $this->preload_model_routes_for_service_provider();
        }

        if ($this->hasOption('openapi') && $this->option('openapi')) {
            $setOptions['withOpenAPI'] = true;
        }

        if ($this->hasOption('revision') && $this->option('revision')) {
            $setOptions['revision'] = true;
        }

        if ($this->hasOption('seeders') && $this->option('seeders')) {
            $setOptions['withSeeders'] = true;
        }

        if ($this->hasOption('test') && $this->option('test')) {
            $setOptions['withTests'] = true;
        }

        if ($this->hasOption('translations') && $this->option('translations')) {
            $setOptions['withTranslations'] = true;
        }

        if (! empty($setOptions)) {
            $this->c->setOptions($setOptions)->apply();
        }
        // dump([
        //    '__METHOD__' => __METHOD__,
        //    '$setOptions' => $setOptions,
        //    '$this->c->recipe()' => $this->c->recipe(),
        // ]);

        $this->searches['config_space'] = $this->c->config_space();
        $this->searches['packagist'] = $this->c->packagist();
        $this->searches['package_license'] = $this->c->package_license();
        $this->searches['organization_email'] = $this->c->organization_email();
        $this->searches['packagist'] = $this->c->packagist();
        $this->searches['packagist'] = $this->c->packagist();
        $this->searches['recipe'] = $this->c->packagist();

        $withTranslations = $this->c->withTranslations();
        if ($withTranslations) {
            $this->searches['phpstan_with_lang'] = '';
        }

        if ($isApi) {
            if ($withTranslations) {
                $ci_phpstan_folders = 'config/ lang/ routes/ src/ tests/Feature/ tests/Unit/';
            } else {
                $ci_phpstan_folders = 'config/ routes/ src/ tests/Feature/ tests/Unit/';
            }
        } elseif ($isResource) {
            if ($withTranslations) {
                $ci_phpstan_folders = 'config/ lang/ resources/views/ routes/ src/ tests/Feature/ tests/Unit/';
            } else {
                $ci_phpstan_folders = 'config/ resources/views/ routes/ src/ tests/Feature/ tests/Unit/';
            }
        } else {
            $ci_phpstan_folders = 'config/ database/ src/ tests/Feature/ tests/Unit/';
        }

        $this->searches['ci_phpstan_folders'] = $ci_phpstan_folders;

        if ($this->c->playground() && in_array($this->c->type(), [
            'playground-model',
        ])) {
            $this->prepare_published_models();
            $this->prepare_readme_env_vars();
            $this->prepare_seeders_for_readme();
        }

        if ($this->hasOption('package-version')
            && is_string($this->option('package-version'))
            && $this->option('package-version')
        ) {
            $this->c->setOptions([
                'version' => $this->option('package-version'),
            ]);
            $this->searches['version'] = $this->c->version();
        }

        $this->make_composer_package_name();

        if (! empty($this->modelPackage?->package())) {
            $this->c->setOptions([
                'model_package' => $this->modelPackage->package(),
                'model_package_name' => $this->modelPackage->package_name(),
            ]);

        }

        $this->c->apply();

        if (in_array($this->c->type(), [
            'model',
            'playground-model',
        ])) {
            $this->prepare_models_for_readme();
        }

        if ($build) {
            if (in_array($this->c->type(), [
                'api',
                'playground-api',
                'resource',
                'playground-resource',
            ])) {
                $this->createBaseController();
                $this->createResourceIndexController();
                $this->build_crud();
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$withRoutes' => $withRoutes,
        //     '$this->c' => $this->c,
        // ]);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->c' => $this->c,
        //     '$this->options()' => $this->options(),
        // //                     '$this->modelPackage' => $this->modelPackage,
        // //                     '$this->searches' => $this->searches,
        //     '$this->c->package_model()' => $this->c->package_model(),
        // ]);
    }

    public function finish(): ?bool
    {
        $build = $this->hasOption('build') && $this->option('build');
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$build' => $build,
        //     '$this->c->type()' => $this->c->type(),
        // ]);

        if (! $build) {
            if (in_array($this->c->type(), [
                'model',
                'playground-model',
            ])) {
                $this->handle_models();
                $this->handle_seeders();
            }

            if (in_array($this->c->type(), [
                'api',
                'playground-api',
                'resource',
                'playground-resource',
            ])) {
                $this->handle_controllers();
            }
        }

        //         dd([
        //             '__METHOD__' => __METHOD__,
        //             '$build' => $build,
        //             '$this->c->type()' => $this->c->type(),
        //             '$this->c' => $this->c,
        //             '$this->searches' => $this->searches,
        //         ]);

        // $this->saveConfiguration();

        $this->setPackageAuthor();
        $this->setPackageDescription();
        $this->setPackageKeywords();
        $this->setPackageHomepage();
        $this->setPackageRequire();
        $this->setPackageProviders();
        $this->setPackageSuggest();
        $this->setPackageVersion();

        $this->c->apply();
        $this->applyConfigurationToSearch();
        $this->saveConfiguration();

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        // ]);

        $this->createComposerJson();
        $this->createConfig();
        $this->createSkeleton();

        $this->saveConfiguration();

        if ($this->c->withTests()) {
            $this->createTest();
        }

        // Reset
        $this->c->reset()->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->c' => $this->c,
        //     //'$this->searches' => $this->searches,
        // ]);
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

        $type = $this->c->type();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$this->c' => $this->c,
        // ]);
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

    public function handleName(string $name): string
    {
        return 'ServiceProvider';
    }
}
