<?php

namespace Dbt\LaravelProject\Tests\Integration;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Session\Middleware\StartSession;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class IntegrationTestCase extends Orchestra
{
    /**
     * Perform test application bootstrapping.
     */
    protected function setUp (): void
    {
        parent::setUp();
    }

    /**
     * Define environment setup.
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp ($app)
    {
        $config = resolve(Repository::class);

        $config->set('app.key', 'base64:2+SetJaztC7g0a1sSF81LYsDasiWymO6tp8yVv6KGrA=');
        $config->set('database.default', 'mysql');

        $config->set('database.connections.mysql', [
            'driver'   => env('DB_DRIVER'),
            'host' =>  env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'prefix'   => env('DB_PASSWORD'),
        ]);

        $config->set('session', [
            'driver'          => env('SESSION_DRIVER'),
            'lifetime'        => 120,
            'expire_on_close' => false,
            'encrypt'         => false,
            'lottery'         => [2, 100],
            'path'            => '/',
            'domain'          => 'localhost',
            'secure'          => false,
        ]);

        resolve(Kernel::class)->pushMiddleware(StartSession::class);
    }
}
