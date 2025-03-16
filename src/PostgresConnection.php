<?php

namespace Belamov\PostgresRange;

use Illuminate\Database\Grammar;
use Illuminate\Database\PostgresConnection as LaravelPostgresConnection;

class PostgresConnection extends LaravelPostgresConnection
{
    /**
     * @return Grammar
     */
    protected function getDefaultSchemaGrammar(): Grammar
    {
        return new PostgresGrammarWithRangeTypes($this);
    }
}
