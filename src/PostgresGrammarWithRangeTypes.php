<?php

namespace Belamov\PostgresRange;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;

class PostgresGrammarWithRangeTypes extends PostgresGrammar
{
    protected string $timeRangeTypeName = 'timerange';
    protected string $timeDiffFunctionName = 'time_subtype_diff';

    /**
     * @return string
     */
    public function typeDaterange(): string
    {
        return 'daterange';
    }

    /**
     * @return string
     */
    public function typeTsrange(): string
    {
        return 'tsrange';
    }

    /**
     * @return string
     */
    public function typeNumrange(): string
    {
        return 'numrange';
    }

    /**
     * @return string
     */
    public function typeInt4range(): string
    {
        return 'int4range';
    }

    /**
     * @return string
     */
    public function typeInt8range(): string
    {
        return 'int8range';
    }

    /**
     * @return string
     */
    public function typeTimeRange(): string
    {
        $this->addTimeRangeType();

        return 'timerange';
    }

    protected function addTimeRangeType(): void
    {
        DB::statement(
            "CREATE OR REPLACE FUNCTION {$this->timeDiffFunctionName}(x time, y time) RETURNS float8 AS
        'SELECT EXTRACT(EPOCH FROM (x - y))' LANGUAGE sql STRICT IMMUTABLE;"
        );

        DB::statement("DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = '{$this->timeRangeTypeName}') THEN
                CREATE TYPE {$this->timeRangeTypeName} AS RANGE (
                    subtype = time,
                    subtype_diff = {$this->timeDiffFunctionName}
                );
            END IF;
        END$$;"
        );
    }

    public function getFluentCommands(): array
    {
        return array_merge(parent::getFluentCommands(), ['uniqueRange']);
    }

    /**
     * @param  Blueprint  $blueprint
     * @param  Fluent  $command
     * @return string
     */
    public function compileUniqueRange(Blueprint $blueprint, Fluent $command): string
    {
        if (! empty($command->additionalColumns)) {
            $this->addBtreeGistExtension();
        }

        return sprintf('alter table %s add exclude using gist (%s %s with &&)',
            $this->wrapTable($blueprint),
            $this->getAdditionalColumnsForExclude($command->additionalColumns),
            $this->wrap($command->column)
        );
    }

    protected function addBtreeGistExtension(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS btree_gist;');
    }

    /**
     * @param  array  $additionalColumns
     * @return string
     */
    private function getAdditionalColumnsForExclude(array $additionalColumns): string
    {
        $columns = '';

        foreach ($additionalColumns as $additionalColumn) {
            $columns .= "{$additionalColumn} WITH =,";
        }

        return $columns;
    }
}
