<?php

namespace Belamov\PostgresRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class TimestampTzRange.
 *
 * @method CarbonImmutable|null from()
 * @method CarbonImmutable|null to()
 */
class TimestampTzRange extends TimestampRange
{
    public function forSql(): string
    {
        return "'$this'::tstzrange";
    }
}
