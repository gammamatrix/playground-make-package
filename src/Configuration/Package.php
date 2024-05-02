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
        'package_name' => '',
        // 'package_autoload' => '',
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
        // 'version' => '0.1.2-alpha.3',
        'version' => '',
    ];

    protected string $class = 'ServiceProvider';

    protected bool $withControllers = false;

    protected bool $withFactories = false;

    protected bool $withMigrations = false;

    protected bool $withModels = false;

    protected bool $withPolicies = false;

    protected string $package_name = '';

    // protected string $package_autoload = '';

    protected string $package_description = '';

    /**
     * @var array<int, string>
     */
    protected array $package_keywords = [];

    protected string $package_homepage = '';

    protected string $package_license = '';

    /**
     * @var array<string, string>
     */
    protected array $package_require = [];

    /**
     * @var array<string, string>
     */
    protected array $package_require_dev = [];

    /**
     * @var array<int, string>
     */
    protected array $package_autoload_psr4 = [];

    /**
     * @var array<int, string>
     */
    protected array $package_laravel_providers = [];

    protected string $packagist = '';

    /**
     * @var array<int, string>
     */
    protected array $controllers = [];

    /**
     * @var array<int, string>
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
     * @var array<int, string>
     */
    protected array $routes = [];

    /**
     * @var array<int, string>
     */
    protected array $transformers = [];

    protected string $service_provider = '';

    protected string $version = '';

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('withControllers', $options)) {
            $this->withControllers = ! empty($options['withControllers']);
        }

        if (array_key_exists('withFactories', $options)) {
            $this->withFactories = ! empty($options['withFactories']);
        }

        if (array_key_exists('withMigrations', $options)) {
            $this->withMigrations = ! empty($options['withMigrations']);
        }

        if (array_key_exists('withModels', $options)) {
            $this->withModels = ! empty($options['withModels']);
        }

        if (array_key_exists('withPolicies', $options)) {
            $this->withPolicies = ! empty($options['withPolicies']);
        }

        if (! empty($options['package_name'])
            && is_string($options['package_name'])
        ) {
            $this->package_name = $options['package_name'];
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

        if (! empty($options['package_laravel_providers'])
            && is_array($options['package_laravel_providers'])
        ) {
            foreach ($options['package_laravel_providers'] as $provider) {
                $this->addClassTo('package_laravel_providers', $provider);
            }
        }

        if (! empty($options['packagist'])
            && is_string($options['packagist'])
        ) {
            $this->packagist = $options['packagist'];
        }

        if (! empty($options['controllers'])
            && is_array($options['controllers'])
        ) {
            foreach ($options['controllers'] as $file) {
                $this->addClassFileTo('controllers', $file);
            }
        }

        if (! empty($options['models'])
            && is_array($options['models'])
        ) {
            foreach ($options['models'] as $file) {
                $this->addClassFileTo('models', $file);
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

    public function withPolicies(): bool
    {
        return $this->withPolicies;
    }

    public function package_name(): string
    {
        return $this->package_name;
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
     * @return array<int, string>
     */
    public function package_autoload_psr4(): array
    {
        return $this->package_autoload_psr4;
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

    /**
     * @return array<int, string>
     */
    public function controllers(): array
    {
        return $this->controllers;
    }

    /**
     * @return array<int, string>
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
     * @return array<int, string>
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
