<?php

namespace Belamov\PostgresRange;

use Belamov\PostgresRange\Macros\BluePrintMacros;
use Belamov\PostgresRange\Macros\QueryBuilderMacros;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class PostgresRangeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->setCustomResolverForPgsql();
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'postgres-range');
    }

    protected function setCustomResolverForPgsql(): void
    {
        Connection::resolverFor('pgsql', static function ($connection, $database, $prefix, $config) {
            return new PostgresConnection($connection, $database, $prefix, $config);
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('postgres-range.php'),
            ], 'config');
        }

        (new BluePrintMacros())->register();
        (new QueryBuilderMacros())->register();
    }
}
