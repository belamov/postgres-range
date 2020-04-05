<?php

namespace Belamov\PostrgesRange;

use Illuminate\Support\Facades\Facade;

class PostrgesRangeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'postrges-range';
    }
}
