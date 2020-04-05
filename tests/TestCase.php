<?php

namespace Belamov\PostrgesRange\Tests;

use Belamov\PostrgesRange\PostrgesRangeServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'db'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'ranges'),
            'username' => env('DB_USERNAME', 'ranges'),
            'password' => env('DB_PASSWORD', '450ta0HMbuASVWlT'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [PostrgesRangeServiceProvider::class];
    }
}
