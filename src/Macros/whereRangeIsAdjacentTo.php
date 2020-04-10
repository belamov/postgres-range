<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeAdjacentTo',
    function ($left, $right) {
        return $this->whereRaw('? -|- ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeAdjacentTo',
    function ($left, $right) {
        return $this->whereRaw('? -|- ?', [$left, $right], 'or');
    }
);
