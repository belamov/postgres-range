<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeIsContainedBy',
    function ($left, $right) {
        return $this->whereRaw('? <@ ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeIsContainedBy',
    function ($left, $right) {
        return $this->whereRaw('? <@ ?', [$left, $right], 'or');
    }
);
