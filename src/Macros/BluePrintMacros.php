<?php

namespace Belamov\PostgresRange\Macros;

use Illuminate\Database\Schema\Blueprint;

class BluePrintMacros
{
    private array $columnTypes = [
        ['dateRange', 'daterange'],
        ['timestampRange', 'tsrange'],
        ['floatRange', 'numrange'],
        ['integerRange', 'int4range'],
        ['bigIntegerRange', 'int8range'],
        ['timeRange', 'timerange'],
    ];

    public function register(): void
    {
        foreach ($this->columnTypes as [$columnTypeForMacro, $columnTypeForPostgres]) {
            Blueprint::macro(
                $columnTypeForMacro,
                fn(string $columnName) => $this->addColumn($columnTypeForPostgres, $columnName)
            );
        }

        Blueprint::macro('excludeRangeOverlapping', function ($columnName, ...$additionalColumns) {
            return $this->addCommand('excludeRangeOverlapping', [
                'column' => $columnName,
                'additionalColumns' => $additionalColumns,
            ]);
        });
    }
}


