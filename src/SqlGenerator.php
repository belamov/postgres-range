<?php

namespace Belamov\PostgresRange;

use Illuminate\Support\Facades\DB;

class SqlGenerator
{
    protected string $tableName;
    protected string $timeRangeTypeName;
    protected string $timeDiffFunctionName;

    /**
     * @param  string  $tableName
     * @param  string  $timeRangeTypeName
     * @param  string  $timeDiffFunctionName
     */
    public function __construct(
        string $tableName,
        string $timeRangeTypeName = 'timerange',
        string $timeDiffFunctionName = 'time_subtype_diff'
    ) {
        $this->tableName = $tableName;
        $this->timeRangeTypeName = $timeRangeTypeName;
        $this->timeDiffFunctionName = $timeDiffFunctionName;
    }

    /**
     * @param  string  $columnName
     * @param  bool  $nullable
     * @param  null  $default
     */
    public function timestampRange(string $columnName, bool $nullable = false, ?string $default = null): void
    {
        $this->addColumn($columnName, 'tsrange', $nullable, $default);
    }

    /**
     * @param  string  $columnName
     * @param  string  $type
     * @param  bool  $nullable
     * @param  string|null  $default
     * @return void
     */
    private function addColumn(string $columnName, string $type, bool $nullable, ?string $default): void
    {
        $nullableString = $this->getNullString($nullable);
        $defaultString = $this->getDefaultString($default);
        DB::statement(
            "
            ALTER TABLE {$this->tableName}
            ADD COLUMN {$columnName} {$type} {$nullableString} {$defaultString};
        "
        );
    }

    /**
     * @param  bool  $nullable
     * @return string
     */
    protected function getNullString(bool $nullable): string
    {
        return $nullable ? 'NULL' : 'NOT NULL';
    }

    /**
     * @param  string|null  $default
     * @return string
     */
    protected function getDefaultString(?string $default): string
    {
        return $default ? "DEFAULT '$default'" : '';
    }

    /**
     * @param  string  $columnName
     * @param  bool  $nullable
     * @param  string|null  $default
     */
    public function timeRange(string $columnName, bool $nullable = false, ?string $default = null): void
    {
        $this->addTimeRangeType();
        $this->addColumn($columnName, $this->timeRangeTypeName, $nullable, $default);
    }

    private function addTimeRangeType(): void
    {
        DB::statement(
            "
            CREATE OR REPLACE FUNCTION {$this->timeDiffFunctionName}(x time, y time) RETURNS float8 AS
            'SELECT EXTRACT(EPOCH FROM (x - y))' LANGUAGE sql STRICT IMMUTABLE;
        "
        );

        DB::statement(
            "
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = '{$this->timeRangeTypeName}') THEN
                CREATE TYPE {$this->timeRangeTypeName} AS RANGE (
                    subtype = time,
                    subtype_diff = {$this->timeDiffFunctionName}
                );
            END IF;
        END$$;
        "
        );
    }

    /**
     * @param  string  $columnName
     */
    public function gistIndex(string $columnName): void
    {
        DB::statement(
            "
            CREATE INDEX ON {$this->tableName} USING GIST ({$columnName});
        "
        );
    }

    /**
     * @param  string  $columnName
     * @param  mixed  ...$additionalColumns
     */
    public function unique(string $columnName, ...$additionalColumns): void
    {
        if (empty($additionalColumns)) {
            $this->addGistUnique($columnName);

            return;
        }

        $this->addGistBTreeUnique($columnName, $additionalColumns);
    }

    /**
     * @param  string  $columnName
     */
    private function addGistUnique(string $columnName): void
    {
        DB::statement(
            "
            ALTER TABLE {$this->tableName}
            ADD EXCLUDE USING GIST ({$columnName} WITH &&);
        "
        );
    }

    /**
     * @param  string  $columnName
     * @param  array  $additionalColumns
     */
    private function addGistBTreeUnique(string $columnName, array $additionalColumns): void
    {
        $this->addBtreeGistExtension();

        $columns = $this->getAdditionalColumnsForIndex($additionalColumns);

        DB::statement(
            "
            ALTER TABLE {$this->tableName}
            ADD EXCLUDE USING GIST ({$columns} {$columnName} WITH &&);
        "
        );
    }

    private function addBtreeGistExtension(): void
    {
        DB::statement(
            '
            CREATE EXTENSION IF NOT EXISTS btree_gist;
        '
        );
    }

    /**
     * @param  array  $additionalColumns
     * @return string
     */
    private function getAdditionalColumnsForIndex(array $additionalColumns): string
    {
        $columns = '';
        foreach ($additionalColumns as $additionalColumn) {
            $columns .= "{$additionalColumn} WITH =,";
        }

        return $columns;
    }

    /**
     * @param  string  $columnName
     * @param  bool  $nullable
     * @param  string|null  $default
     */
    public function numberRange(string $columnName, bool $nullable = false, ?string $default = null): void
    {
        $this->addColumn($columnName, 'numrange', $nullable, $default);
    }

    /**
     * @param  string  $columnName
     * @param  bool  $nullable
     * @param  string|null  $default
     */
    public function integerRange(string $columnName, bool $nullable = false, ?string $default = null): void
    {
        $this->addColumn($columnName, 'int4range', $nullable, $default);
    }

    /**
     * @param  string  $columnName
     * @param  bool  $nullable
     * @param  string|null  $default
     */
    public function bigintRange(string $columnName, bool $nullable = false, ?string $default = null): void
    {
        $this->addColumn($columnName, 'int8range', $nullable, $default);
    }

    /**
     * @param  string  $columnName
     * @param  bool  $nullable
     * @param  string|null  $default
     */
    public function dateRange(string $columnName, bool $nullable = false, ?string $default = null): void
    {
        $this->addColumn($columnName, 'daterange', $nullable, $default);
    }
}
