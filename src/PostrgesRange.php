<?php

namespace Belamov\PostrgesRange;

use Illuminate\Support\Facades\DB;

class PostrgesRange
{
    public static function timestampRange(string $table, string $column, bool $nullable = false)
    {
        $nullableString = self::getNullString($nullable);
        DB::statement("
            ALTER TABLE $table
            ADD COLUMN $column tsrange $nullableString;
        ");
    }

    /**
     * @param bool $nullable
     * @return string
     */
    private static function getNullString(bool $nullable): string
    {
        return $nullable ? 'NULL' : 'NOT NULL';
    }

    public static function dateRange(string $table, string $column, bool $nullable = false)
    {
        $nullableString = self::getNullString($nullable);
        DB::statement("
            ALTER TABLE $table
            ADD COLUMN $column daterange $nullableString;
        ");
    }

    public static function numberRange(string $table, string $column, bool $nullable = false)
    {
        $nullableString = self::getNullString($nullable);
        DB::statement("
            ALTER TABLE $table
            ADD COLUMN $column numrange $nullableString;
        ");
    }

    public static function integerRange(string $table, string $column, bool $nullable = false)
    {
        $nullableString = self::getNullString($nullable);
        DB::statement("
            ALTER TABLE $table
            ADD COLUMN $column int4range $nullableString;
        ");
    }

    public static function bigintRange(string $table, string $column, bool $nullable = false)
    {
        $nullableString = self::getNullString($nullable);
        DB::statement("
            ALTER TABLE $table
            ADD COLUMN $column int8range $nullableString;
        ");
    }

    public static function timeRange(string $table, string $column, bool $nullable = false)
    {
        $nullableString = self::getNullString($nullable);
        DB::statement(
            "
            CREATE OR REPLACE FUNCTION time_subtype_diff(x time, y time) RETURNS float8 AS
            'SELECT EXTRACT(EPOCH FROM (x - y))' LANGUAGE sql STRICT IMMUTABLE;
        "
        );

        DB::statement("
        DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'timerange') THEN
                CREATE TYPE timerange AS RANGE (
                    subtype = time,
                    subtype_diff = time_subtype_diff
                );
            END IF;
        END$$;
        ");
        DB::statement("
        ALTER TABLE $table
        ADD COLUMN $column timerange $nullableString;
        "
        );
    }
}
