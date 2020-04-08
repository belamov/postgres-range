<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeDoesNotExtendToTheLeftOf',
    function ($column, $value) {
        return $this->whereRaw('? &> ?', [$column, $value]);
    }
);

Builder::macro(
    'orWhereRangeDoesNotExtendToTheLeftOf',
    function ($column, $value) {
        return $this->whereRaw('? &> ?', [$column, $value], 'or');
    }
);
