<?php

namespace Belamov\PostgresRange\Tests;

use Belamov\PostgresRange\Models\Range;
use Belamov\PostgresRange\PostgresRangeServiceProvider;

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
            'password' => env('DB_PASSWORD', 'ranges'),
            'charset' => 'utf8',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [PostgresRangeServiceProvider::class];
    }

    /**
     * @param  array  $attributes
     * @return Range
     */
    protected function createModel(array $attributes = []): Range
    {
        return Range::create($attributes);
    }
}
