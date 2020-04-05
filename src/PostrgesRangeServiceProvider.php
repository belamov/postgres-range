<?php

namespace Belamov\PostrgesRange;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class PostrgesRangeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('postrges-range', function () {
            return new PostrgesRange;
        });
    }
}
