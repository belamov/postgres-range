<?php

namespace Belamov\PostgresRange;

use Illuminate\Database\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class PostgresRangeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setCustomResolverForPgsql();
    }

    protected function setCustomResolverForPgsql(): void
    {
        Connection::resolverFor('pgsql', function ($connection, $database, $prefix, $config) {
            return new PostgresConnection($connection, $database, $prefix, $config);
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        Collection::make(glob(__DIR__.'/Macros/*.php'))->mapWithKeys(
            static function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            }
        )->each(
            static function ($macro, $path) {
                require_once $path;
            }
        );
    }
}
