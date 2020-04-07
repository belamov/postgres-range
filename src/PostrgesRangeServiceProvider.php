<?php

namespace Belamov\PostrgesRange;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class PostrgesRangeServiceProvider extends ServiceProvider
{
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
