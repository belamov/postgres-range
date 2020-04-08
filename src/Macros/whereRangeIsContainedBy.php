<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeIsContainedBy',
    function ($column, $value) {
        return $this->whereRaw("{$column} <@ ?", [$value]);
    }
);

Builder::macro(
    'orWhereRangeIsContainedBy',
    function ($column, $value) {
        return $this->whereRaw("{$column} <@ ?", [$value], 'or');
    }
);
