<?php

use Illuminate\Database\Schema\Blueprint;

Blueprint::macro('dateRange', function (string $columnName) {
    return $this->addColumn('daterange', $columnName);
});

Blueprint::macro('timestampRange', function (string $columnName) {
    return $this->addColumn('tsrange', $columnName);
});

Blueprint::macro('floatRange', function (string $columnName) {
    return $this->addColumn('numrange', $columnName);
});

Blueprint::macro('integerRange', function (string $columnName) {
    return $this->addColumn('int4range', $columnName);
});

Blueprint::macro('bigIntegerRange', function (string $columnName) {
    return $this->addColumn('int8range', $columnName);
});

Blueprint::macro('timeRange', function (string $columnName) {
    return $this->addColumn('timerange', $columnName);
});

Blueprint::macro('uniqueRange', function ($columnName, ...$additionalColumns) {
    return $this->addCommand('uniqueRange', [
        'column' => $columnName,
        'additionalColumns' => $additionalColumns,
    ]);
});
