<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

// use Illuminate\Support\Facades\Storage;

/**
 * \Playground\Make\Package\Building\MakeCommands
 */
trait MakeCommands
{
    public function handle_controllers(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$controllers' => $controllers,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->controllers() as $controller) {
            if (is_string($controller) && $controller) {
                $params['--file'] = $controller;
                $this->call('playground:make:controller', $params);
            }
        }
    }

    public function handle_policies(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$his->option(license)' => $this->option('license'),
        //     '$policies' => $policies,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->policies() as $policy) {
            // $file = sprintf('', $policy);
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     // '$his->option(license)' => $this->option('license'),
            //     '$policy' => $policy,
            // ]);
            $params['--file'] = $policy;
            $this->call('playground:make:policy', $params);
        }

        // if (! class_exists($parentModelClass) &&
        //     confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", default: true)) {
        //     $this->call('playground:make:model', ['name' => $parentModelClass]);
        // }
    }

    public function handle_requests(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$requests' => $requests,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->requests() as $request) {
            if (is_string($request) && $request) {
                $params['--file'] = $request;
                // dump([
                //     '__METHOD__' => __METHOD__,
                //     '$request' => $request,
                // ]);
                $this->call('playground:make:request', $params);
            }
        }
    }
}
