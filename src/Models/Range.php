<?php

namespace Belamov\PostgresRange\Models;

use Belamov\PostgresRange\Casts\DateRangeCast;
use Belamov\PostgresRange\Casts\FloatRangeCast;
use Belamov\PostgresRange\Casts\IntegerRangeCast;
use Belamov\PostgresRange\Casts\TimeRangeCast;
use Belamov\PostgresRange\Casts\TimestampRangeCast;
use Belamov\PostgresRange\Ranges\DateRange;
use Belamov\PostgresRange\Ranges\FloatRange;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Ranges\TimeRange;
use Belamov\PostgresRange\Ranges\TimestampRange;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Range
 *
 * @property TimestampRange $timestamp_range
 * @property TimeRange $time_range
 * @property FloatRange $float_range
 * @property IntegerRange $integer_range
 * @property IntegerRange $bigint_range
 * @property DateRange $date_range
 *
 * @package Belamov\PostgresRange\Models
 */
class Range extends Model
{
    public $timestamps = [];
    protected $guarded = [];
    protected $casts = [
        'timestamp_range' => TimestampRangeCast::class,
        'time_range' => TimeRangeCast::class,
        'float_range' => FloatRangeCast::class,
        'integer_range' => IntegerRangeCast::class,
        'bigint_range' => IntegerRangeCast::class,
        'date_range' => DateRangeCast::class
    ];
}
