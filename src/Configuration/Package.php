<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Make\Package\Configuration;

use Illuminate\Support\Facades\Log;
use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Package\Configuration\Package
 */
class Package extends PrimaryConfiguration
{
    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => 'ServiceProvider',
        'config' => '',
        'config_space' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'organization_email' => '',
        'package' => '',
        // properties
        'withBlades' => false,
        'withControllers' => false,
        'withFactories' => false,
        'withMigrations' => false,
        'withModels' => false,
        'withOpenAPI' => false,
        'withPolicies' => false,
        'withRequests' => false,
        'withRoutes' => false,
        'withSeeders' => false,
        'withTests' => false,
        'withTranslations' => false,
        'playground' => false,
        'revision' => false,
        'docs_name' => '',
        'docs_url' => '',
        'package_name' => '',
        'model_package' => '',
        'model_package_name' => '',
        // 'package_autoload' => '',
        'package_description' => '',
        'package_homepage' => '',
        'package_license' => '',
        'packagist' => '',
        'postman_collection' => '',
        'postman_url' => '',
        'service_provider' => '',
        // 'version' => '0.1.2-alpha.3',
        'type' => '',
        'version' => '',
        'package_authors' => [],
        'package_autoload_psr4' => [],
        'package_autoload_dev_psr4' => [],
        'package_keywords' => [],
        'package_laravel_providers' => [],
        'package_providers' => [],
        'package_repositories' => [],
        'package_require' => [],
        'package_require_dev' => [],
        'package_suggest' => [],
        'controllers' => [],
        'models' => [],
        'policies' => [],
        'requests' => [],
        'routes' => [],
        'seeders' => [],
        'transformers' => [],
        'translations' => [],
        'uses' => [],
    ];

    protected string $class = 'ServiceProvider';

    protected bool $withBlades = false;

    protected bool $withControllers = false;

    protected bool $withFactories = false;

    protected bool $withMigrations = false;

    protected bool $withModels = false;

    protected bool $withOpenAPI = false;

    protected bool $withPolicies = false;

    protected bool $withRequests = false;

    protected bool $withRoutes = false;

    protected bool $withSeeders = false;

    protected bool $withTests = false;

    protected bool $withTranslations = false;

    protected bool $revision = false;

    protected string $config_space = '';

    protected string $docs_name = '';

    protected string $docs_url = '';

    protected string $organization_email = '';

    protected string $model_package = '';

    protected string $model_package_name = '';

    protected string $package_name = '';

    // protected string $package_autoload = '';

    protected string $package_description = '';

    /**
     * @var array<int, string>
     */
    protected array $package_keywords = [];

    protected string $package_homepage = '';

    /**
     * @var array<int, array<string, string>>
     */
    protected array $package_authors = [];

    protected string $package_license = '';

    /**
     * @var array<int, array<string, string>>
     */
    protected array $package_repositories = [];

    /**
     * @var array<string, string>
     */
    protected array $package_require = [];

    /**
     * @var array<string, string>
     */
    protected array $package_require_dev = [];

    /**
     * @var array<string, string>
     */
    protected array $package_suggest = [];

    /**
     * @var array<int, string>
     */
    protected array $package_autoload_psr4 = [];

    /**
     * @var array<int, string>
     */
    protected array $package_autoload_dev_psr4 = [];

    /**
     * @var array<int, string>
     */
    protected array $package_providers = [];

    /**
     * @var array<int, string>
     */
    protected array $package_laravel_providers = [];

    protected string $packagist = '';

    protected string $postman_collection = '';

    protected string $postman_url = '';

    /**
     * @var array<int, string>
     */
    protected array $controllers = [];

    /**
     * @var array<string, array<string, array<string, string>>>
     */
    protected array $translations = [
        // 'en' => [
        //    'configuration' => [
        //        'keywords.required' => 'Ignoring a keyword [INVALID: :keyword] for the composer.json file.',
        //    ],
        // ],
    ];

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<int, string>
     */
    protected array $policies = [];

    /**
     * @var array<int, string>
     */
    protected array $requests = [];

    /**
     * @var array<string, string>
     */
    protected array $routes = [];

    /**
     * @var array<int, string>
     */
    protected array $transformers = [];

    protected string $service_provider = '';

    protected string $version = '';

    /**
     * @param  array{
     *     config_space?: string,
     *     organization_email?: string,
     *     withBlades?: bool,
     *     withControllers?: bool,
     *     withFactories?: bool,
     *     withMigrations?: bool,
     *     withModels?: bool,
     *     withOpenAPI?: bool,
     *     withPolicies?: bool,
     *     withRequests?: bool,
     *     withRoutes?: bool,
     *     withSeeders?: bool,
     *     withTests?: bool,
     *     withTranslations?: bool,
     *     playground?: bool,
     *     revision?: bool,
     *     docs_name?: string,
     *     docs_url?: string,
     *     package_name?: string,
     *     model_package?: string,
     *     model_package_name?: string,
     *     package_description?: string,
     *     package_homepage?: string,
     *     package_license?: string,
     *     packagist?: string,
     *     postman_collection?: string,
     *     postman_url?: string,
     *     service_provider?: string,
     *     type?: string,
     *     version?: string,
     *     package_authors?: array<int, array<string, string>>,
     *     package_keywords?: string[],
     *     package_repositories?: array<int, array<string, string>>,
     *     package_require?: array<string, string>,
     *     package_require_dev?: array<string, string>,
     *     package_suggest?: array<string, string>,
     *     package_laravel_providers?: string[],
     *     package_providers?: string[],
     *     controllers?: string[],
     *     models?: string[],
     *     policies?: string[],
     *     requests?: string[],
     *     resources?: string[],
     *     routes?: string[],
     *     transformers?: string[],
     *     translations?: string[],
     *     user?: array<int|string, string>,
     * }  $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('withBlades', $options)) {
            $this->withBlades = ! empty($options['withBlades']);
        }

        if (array_key_exists('withControllers', $options)) {
            $this->withControllers = ! empty($options['withControllers']);
        }

        if (array_key_exists('withFactories', $options)) {
            $this->withFactories = ! empty($options['withFactories']);
        }

        if (array_key_exists('withTranslations', $options)) {
            $this->withTranslations = ! empty($options['withTranslations']);
        }

        if (array_key_exists('withMigrations', $options)) {
            $this->withMigrations = ! empty($options['withMigrations']);
        }

        if (array_key_exists('withModels', $options)) {
            $this->withModels = ! empty($options['withModels']);
        }

        if (array_key_exists('withOpenAPI', $options)) {
            $this->withOpenAPI = ! empty($options['withOpenAPI']);
        }

        if (array_key_exists('withPolicies', $options)) {
            $this->withPolicies = ! empty($options['withPolicies']);
        }

        if (array_key_exists('withRequests', $options)) {
            $this->withRequests = ! empty($options['withRequests']);
        }

        if (array_key_exists('withRoutes', $options)) {
            $this->withRoutes = ! empty($options['withRoutes']);
        }

        if (array_key_exists('withSeeders', $options)) {
            $this->withSeeders = ! empty($options['withSeeders']);
        }

        if (array_key_exists('withTests', $options)) {
            $this->withTests = ! empty($options['withTests']);
        }

        if (array_key_exists('revision', $options)) {
            $this->revision = ! empty($options['revision']);
        }

        if (! empty($options['package_name'])

            && is_string($options['package_name'])
        ) {
            $this->package_name = $options['package_name'];
        }

        if (! empty($options['model_package'])

            && is_string($options['model_package'])
        ) {
            $this->model_package = $options['model_package'];
        }

        if (! empty($options['model_package_name'])

            && is_string($options['model_package_name'])
        ) {
            $this->model_package_name = $options['model_package_name'];
        }

        if (! empty($options['config_space'])
            && is_string($options['config_space'])
        ) {
            $this->config_space = $options['config_space'];
        }

        if (! empty($options['docs_name'])
            && is_string($options['docs_name'])
        ) {
            $this->docs_name = $options['docs_name'];
        }

        if (! empty($options['docs_url'])
            && is_string($options['docs_url'])
        ) {
            $this->docs_url = $options['docs_url'];
        }

        if (! empty($options['organization_email'])
            && is_string($options['organization_email'])
        ) {
            $this->organization_email = $options['organization_email'];
        }

        // if (! empty($options['package_autoload'])
        //     && is_string($options['package_autoload'])
        // ) {
        //     $this->package_autoload = $options['package_autoload'];
        // }

        if (! empty($options['package_description'])
            && is_string($options['package_description'])
        ) {
            $this->package_description = $options['package_description'];
        }

        if (! empty($options['package_homepage'])
            && is_string($options['package_homepage'])
        ) {
            $this->package_homepage = $options['package_homepage'];
        }

        if (! empty($options['package_keywords'])
            && is_array($options['package_keywords'])
        ) {
            foreach ($options['package_keywords'] as $keyword) {
                $this->addKeyword($keyword);
            }
        }

        if (! empty($options['package_license'])
            && is_string($options['package_license'])
        ) {
            $this->package_license = $options['package_license'];
        }

        //        if (! empty($options['package_repositories'])
        //            && is_array($options['package_repositories'])
        //        ) {
        //            foreach ($options['package_repositories'] as $repository) {
        //                $this->addPackageRepository($repository);
        //            }
        //        }

        if (! empty($options['package_require'])
            && is_array($options['package_require'])
        ) {
            foreach ($options['package_require'] as $package => $version) {
                $this->addRequire($package, $version);
            }
        }

        if (! empty($options['package_require_dev'])
            && is_array($options['package_require_dev'])
        ) {
            foreach ($options['package_require_dev'] as $package => $version) {
                $this->addRequireDev($package, $version);
            }
        }

        if (! empty($options['package_suggest'])
            && is_array($options['package_suggest'])
        ) {
            foreach ($options['package_suggest'] as $package => $description) {
                $this->addSuggest($package, $description);
            }
        }

        if (! empty($options['package_authors'])
            && is_array($options['package_authors'])
        ) {
            foreach ($options['package_authors'] as $i => $author) {
                $this->addAuthor($i, $author);
            }
        }

        if (! empty($options['package_laravel_providers'])
            && is_array($options['package_laravel_providers'])
        ) {
            foreach ($options['package_laravel_providers'] as $provider) {
                $this->addClassTo('package_laravel_providers', $provider);
            }
        }

        if (! empty($options['package_providers'])
            && is_array($options['package_providers'])
        ) {
            foreach ($options['package_providers'] as $provider) {
                $this->addClassTo('package_providers', $provider);
            }
        }

        if (! empty($options['packagist'])
            && is_string($options['packagist'])
        ) {
            $this->packagist = $options['packagist'];
        }

        if (! empty($options['postman_collection'])
            && is_string($options['postman_collection'])
        ) {
            $this->postman_collection = $options['postman_collection'];
        }

        if (! empty($options['postman_url'])
            && is_string($options['postman_url'])
        ) {
            $this->postman_url = $options['postman_url'];
        }

        if (! empty($options['controllers'])
            && is_array($options['controllers'])
        ) {
            foreach ($options['controllers'] as $file) {
                $this->addClassFileTo('controllers', $file);
            }
        }

        if (! empty($options['policies'])
            && is_array($options['policies'])
        ) {
            foreach ($options['policies'] as $file) {
                $this->addClassFileTo('policies', $file);
            }
        }

        if (! empty($options['requests'])
            && is_array($options['requests'])
        ) {
            foreach ($options['requests'] as $file) {
                $this->addClassFileTo('requests', $file);
            }
        }

        if (! empty($options['resources'])
            && is_array($options['resources'])
        ) {
            foreach ($options['resources'] as $file) {
                $this->addClassFileTo('resources', $file);
            }
        }

        if (! empty($options['routes'])
            && is_array($options['routes'])
        ) {
            foreach ($options['routes'] as $file) {
                $this->addClassFileTo('routes', $file);
            }
        }

        if (! empty($options['transformers'])
            && is_array($options['transformers'])
        ) {
            foreach ($options['transformers'] as $file) {
                $this->addClassFileTo('transformers', $file);
            }
        }

        if (! empty($options['translations']) && is_array($options['translations'])) {
            $this->addLanguages($options['translations']);
        }

        if (! empty($options['service_provider'])
            && is_string($options['service_provider'])
        ) {
            $this->service_provider = $options['service_provider'];
        }

        if (! empty($options['version'])
            && is_string($options['version'])
        ) {
            $this->version = $options['version'];
        }

        return $this;
    }

    public function addKeyword(mixed $keyword): self
    {
        if (empty($keyword) || ! is_string($keyword)) {
            Log::warning(__('playground-make-package::configuration.keywords.required', [
                'keyword' => is_string($keyword) ? $keyword : gettype($keyword),
            ]));
        } elseif (! in_array($keyword, $this->package_keywords)) {
            $this->package_keywords[] = $keyword;
        }

        return $this;
    }

    public function addRequire(mixed $package, mixed $version): self
    {
        if (empty($package) || ! is_string($package)) {
            Log::warning(__('playground-make-package::configuration.require.package.required', [
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]), [
                'package-type' => gettype($package),
                'version-type' => gettype($version),
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]);
        }

        if (empty($version) || ! is_string($version)) {
            Log::warning(__('playground-make-package::configuration.require.version.required', [
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]), [
                'package-type' => gettype($package),
                'version-type' => gettype($version),
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]);
        }

        if (! empty($package) && is_string($package) && ! empty($version) && is_string($version)) {
            $this->package_require[$package] = $version;
        }

        return $this;
    }

    public function addRequireDev(mixed $package, mixed $version): self
    {
        if (empty($package) || ! is_string($package)) {
            Log::warning(__('playground-make-package::configuration.require-dev.package.required', [
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]), [
                'package-type' => gettype($package),
                'version-type' => gettype($version),
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]);
        }

        if (empty($version) || ! is_string($version)) {
            Log::warning(__('playground-make-package::configuration.require-dev.version.required', [
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]), [
                'package-type' => gettype($package),
                'version-type' => gettype($version),
                'package' => is_string($package) ? $package : gettype($package),
                'version' => is_string($version) ? $version : gettype($version),
            ]);
        }

        if (! empty($package) && is_string($package) && ! empty($version) && is_string($version)) {
            $this->package_require_dev[$package] = $version;
        }

        return $this;
    }

    public function addAuthor(mixed $i, mixed $author): self
    {
        $isValid = null;
        if (! is_numeric($i)) {
            Log::warning(__('playground-make-package::configuration.author.invalid', [
                'i' => is_numeric($i) ? $i : gettype($i),
                'author-type' => gettype($author),
            ]), [
                'i-type' => gettype($i),
                'author-type' => gettype($author),
                'i' => is_numeric($i) ? $i : gettype($i),
                'author' => is_array($author) ? $author : gettype($author),
            ]);
        } else {
            $isValid = true;
        }

        // At least the author name is required
        if (empty($author) || ! is_array($author) || empty($author['name'])) {
            Log::warning(__('playground-make-package::configuration.author.invalid', [
                'i' => is_numeric($i) ? $i : gettype($i),
                'author-type' => gettype($author),
            ]), [
                'i-type' => gettype($i),
                'author-type' => gettype($author),
                'i' => is_numeric($i) ? $i : gettype($i),
                'author' => is_array($author) ? $author : gettype($author),
            ]);
        } else {
            $isValid = true;
        }

        if (is_int($i) && ! empty($author) && is_array($author) && ! empty($author['name']) && is_string($author['name'])) {
            $this->package_authors[$i] = [
                'name' => $author['name'],
            ];
            if (! empty($author['email']) && is_string($author['email'])) {
                $this->package_authors[$i]['email'] = $author['email'];
            }
            if (! empty($author['role']) && is_string($author['role'])) {
                $this->package_authors[$i]['role'] = $author['role'];
            }
        }

        return $this;
    }

    public function addSuggest(mixed $package, mixed $description): self
    {
        if (empty($package) || ! is_string($package)) {
            Log::warning(__('playground-make-package::configuration.suggest.package.required', [
                'package' => is_string($package) ? $package : gettype($package),
                'description' => is_string($description) ? $description : gettype($description),
            ]), [
                'package-type' => gettype($package),
                'description-type' => gettype($description),
                'package' => is_string($package) ? $package : gettype($package),
                'description' => is_string($description) ? $description : gettype($description),
            ]);
        }

        if (empty($description) || ! is_string($description)) {
            Log::warning(__('playground-make-package::configuration.suggest.description.required', [
                'package' => is_string($package) ? $package : gettype($package),
                'description' => is_string($description) ? $description : gettype($description),
            ]), [
                'package-type' => gettype($package),
                'description-type' => gettype($description),
                'package' => is_string($package) ? $package : gettype($package),
                'description' => is_string($description) ? $description : gettype($description),
            ]);
        }

        if (! empty($package) && is_string($package) && ! empty($description) && is_string($description)) {
            $this->package_suggest[$package] = $description;
        }

        return $this;
    }

    public function addRoute(
        string $slug,
        string $file = ''
    ): self {

        if (empty($slug)) {
            throw new \RuntimeException(__('playground-make-package::configuration.addRoute.slug.required', [
                'class' => static::class,
                'file' => $file,
            ]));
        }

        $this->routes[$slug] = $file;

        return $this;
    }

    public function addLanguages(mixed $languages): self
    {
        if (! empty($languages) && is_array($languages)) {
            /**
             * @var array<string, array<string, string>> $sections
             */
            foreach ($languages as $language => $sections) {
                if (! empty($language)
                    && is_string($language)
                    && ! empty($sections)
                    && is_array($sections)
                ) {
                    $this->addSections($language, $sections);
                }
            }
        }

        return $this;
    }

    /**
     * @param  array<string, array<string, string>>  $sections
     */
    public function addSections(string $language, array $sections): self
    {
        foreach ($sections as $section => $translations) {
            if (! empty($section) && is_string($section)) {
                $this->addSection($language, $section, $translations);
            } else {
                Log::warning(__('playground-make-package::configuration.translations.section.invalid', [
                    'language' => $language,
                    'section' => $section,
                    'TYPE: translations' => gettype($translations),
                ]));
            }
        }

        return $this;
    }

    /**
     * @param  array<string, string>  $translations
     */
    public function addSection(string $language, string $section, array $translations): self
    {
        if (! empty($language) && ! empty($section) && ! empty($translations)) {
            $this->addTranslations($language, $section, $translations);
        } else {
            Log::warning(__('playground-make-package::configuration.translations.section.invalid', [
                'language' => $language,
                'section' => $section,
                'TYPE: translations' => gettype($translations),
            ]));
        }

        return $this;
    }

    /**
     * @param  array<string, string>  $translations
     */
    public function addTranslations(
        string $language,
        string $section,
        array $translations
    ): self {

        foreach ($translations as $key => $message) {
            // It is ok for messages to be empty for building skeleton files automated translations.
            if (empty($key) || ! is_string($key) || ! is_string($message)) {
                Log::warning(__('playground-make-package::configuration.translations.invalid', [
                    'language' => $language,
                    'section' => $section,
                    'key' => $key,
                    'message' => $message,
                ]));
            } else {
                $this->addTranslation($language, $section, $key, $message);
            }
        }

        return $this;
    }

    public function addTranslation(
        string $language,
        string $section,
        string $key,
        string $message
    ): self {
        if (empty($language) || empty($section) || empty($key)) {
            Log::warning(__('playground-make-package::configuration.translations.invalid', [
                'language' => $language,
                'section' => $section,
                'key' => $section,
                'message' => $section,
            ]));

            return $this;
        }

        if (! is_array($this->translations[$language])) {
            $this->translations[$language] = [];
        }

        if (! is_array($this->translations[$language][$section])) {
            $this->translations[$language][$section] = [];
        }

        $this->translations[$language][$section][$key] = $message;

        return $this;
    }

    public function withBlades(): bool
    {
        return $this->withBlades;
    }

    public function withControllers(): bool
    {
        return $this->withControllers;
    }

    public function withFactories(): bool
    {
        return $this->withFactories;
    }

    public function withMigrations(): bool
    {
        return $this->withMigrations;
    }

    public function withModels(): bool
    {
        return $this->withModels;
    }

    public function withOpenAPI(): bool
    {
        return $this->withOpenAPI;
    }

    public function withPolicies(): bool
    {
        return $this->withPolicies;
    }

    public function withRequests(): bool
    {
        return $this->withRequests;
    }

    public function withRoutes(): bool
    {
        return $this->withRoutes;
    }

    public function withSeeders(): bool
    {
        return $this->withSeeders;
    }

    public function withTests(): bool
    {
        return $this->withTests;
    }

    public function withTranslations(): bool
    {
        return $this->withTranslations;
    }

    public function revision(): bool
    {
        return $this->revision;
    }

    public function config_space(): string
    {
        return $this->config_space;
    }

    public function docs_name(): string
    {
        return $this->docs_name;
    }

    public function docs_url(): string
    {
        return $this->docs_url;
    }

    public function organization_email(): string
    {
        return $this->organization_email;
    }

    public function package_name(): string
    {
        return $this->package_name;
    }

    public function model_package(): string
    {
        return $this->model_package;
    }

    public function model_package_name(): string
    {
        return $this->model_package_name;
    }

    // public function package_autoload(): string
    // {
    //     return $this->package_autoload;
    // }

    public function package_description(): string
    {
        return $this->package_description;
    }

    public function package_homepage(): string
    {
        return $this->package_homepage;
    }

    /**
     * @return array<int, string>
     */
    public function package_keywords(): array
    {
        return $this->package_keywords;
    }

    public function package_license(): string
    {
        return $this->package_license;
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function package_authors(): array
    {
        return $this->package_authors;
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function package_repositories(): array
    {
        return $this->package_repositories;
    }

    /**
     * @return array<string, string>
     */
    public function package_require(): array
    {
        return $this->package_require;
    }

    /**
     * @return array<string, string>
     */
    public function package_require_dev(): array
    {
        return $this->package_require_dev;
    }

    /**
     * @return array<string, string>
     */
    public function package_suggest(): array
    {
        return $this->package_suggest;
    }

    /**
     * @return array<int, string>
     */
    public function package_autoload_psr4(): array
    {
        return $this->package_autoload_psr4;
    }

    /**
     * @return array<int, string>
     */
    public function package_autoload_dev_psr4(): array
    {
        return $this->package_autoload_dev_psr4;
    }

    /**
     * package_providers is used for tests in the PackageProviders trait.
     *
     * @return array<int, string>
     */
    public function package_providers(): array
    {
        return $this->package_providers;
    }

    /**
     * @return array<int, string>
     */
    public function package_laravel_providers(): array
    {
        return $this->package_laravel_providers;
    }

    public function packagist(): string
    {
        return $this->packagist;
    }

    public function postman_collection(): string
    {
        return $this->postman_collection;
    }

    public function postman_url(): string
    {
        return $this->postman_url;
    }

    /**
     * @return array<int, string>
     */
    public function controllers(): array
    {
        return $this->controllers;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }

    /**
     * @return array<int, string>
     */
    public function policies(): array
    {
        return $this->policies;
    }

    /**
     * @return array<int, string>
     */
    public function requests(): array
    {
        return $this->requests;
    }

    /**
     * @return array<string, string>
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @return array<int, string>
     */
    public function transformers(): array
    {
        return $this->transformers;
    }

    public function service_provider(): string
    {
        return $this->service_provider;
    }

    public function version(): string
    {
        return $this->version;
    }
}
