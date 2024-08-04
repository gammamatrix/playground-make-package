<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Illuminate\Support\Str;

/**
 * \Playground\Make\Package\Building\BuildServiceProvider
 */
trait BuildServiceProvider
{
    protected function make_service_provider_routes(): void
    {
        $this->searches['about_routes'] = '';

        $about_routes = '';
        $config_routes = '';
        $load_routes = '';

        $about_line = '%1$s\'<fg=red;options=bold>Route</> %2$s\' => ! empty($routes[\'%2$s\']) ? \'<fg=green;options=bold>ENABLED</>\' : \'<fg=yellow;options=bold>DISABLED</>\',%3$s';

        $route_line = '%1$s\'%2$s\' => (bool) env(\'%3$s_%4$s\', %5$s),%6$s';
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c->routes()' => $this->c->routes(),
        //     // '$this->c' => $this->c->toArray(),
        // ]);

        $i = 0;
        foreach ($this->c->routes() as $route => $file) {
            $about_routes .= sprintf($about_line,
                str_repeat(static::INDENT, 3),
                $route,
                PHP_EOL,
            );
            $config_routes .= sprintf($route_line,
                str_repeat(static::INDENT, 2),
                $route,
                $this->c->config_space(),
                strtoupper($route),
                'true',
                PHP_EOL,
            );
            $i++;
            $load_routes .= <<<PHP_CODE

        if (! empty(\$config['$route'])) {
            \$this->loadRoutesFrom(dirname(__DIR__).'/routes/$route.php');
        }
PHP_CODE;
        }

        if (! empty($about_routes)) {
            $this->searches['about_routes'] = $about_routes;
        }

        if (! empty($config_routes)) {
            $this->searches['config_routes'] = rtrim($config_routes);
        }

        if (! empty($load_routes)) {
            $this->searches['load_routes'] = $load_routes;
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$about_routes' => $about_routes,
        //     '$config_routes' => $config_routes,
        //     '$this->searches' => $this->searches,
        //     // '$this->searches[about_routes]' => $this->searches['about_routes'],
        //     // '$this->c->routes()' => $this->c->routes(),
        //     '$this->c' => $this->c->toArray(),
        // ]);
    }

    public function preload_model_routes_for_service_provider(): void
    {
        $isApi = $this->hasOption('api') && $this->option('api');

        $config_abilities_manager = '';
        $config_abilities_user = '';

        $manager_line = '%1$s\'%2$s:%3$s:*\',%4$s';
        $user_line = '%1$s\'%2$s:%3$s:view\',%4$s';
        $user_line .= '%1$s\'%2$s:%3$s:viewAny\',%4$s';

        if (! $isApi && $this->c->module_slug()) {
            $this->c->addRoute($this->c->module_slug());
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$isApi' => $isApi,
        //     '$this->c->routes()' => $this->c->routes(),
        // ]);

        $models = $this->modelPackage?->models() ?? [];

        foreach ($models as $model => $file) {

            if (Str::of($model)->endsWith('Revision')) {
                continue;
            }
            $model_plural_slug = Str::of($model)->plural()->kebab()->toString();
            $model_slug = Str::of($model)->slug()->toString();
            if ($model_plural_slug) {
                $this->c->addRoute($model_plural_slug);
            }

            $config_abilities_manager .= sprintf($manager_line,
                str_repeat(static::INDENT, 3),
                $this->c->package(),
                $model_slug,
                PHP_EOL,
            );

            $config_abilities_user .= sprintf($user_line,
                str_repeat(static::INDENT, 3),
                $this->c->package(),
                $model_slug,
                PHP_EOL,
            );
        }

        if (! empty($config_abilities_manager)) {
            $this->searches['config_abilities_manager'] = rtrim($config_abilities_manager);
        }

        if (! empty($config_abilities_user)) {
            $this->searches['config_abilities_user'] = rtrim($config_abilities_user);
        }

        $this->make_service_provider_routes();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$models' => $models,
        //     '$this->c->routes()' => $this->c->routes(),
        // ]);
    }
}
