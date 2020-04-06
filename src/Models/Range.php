<?php

namespace Belamov\PostrgesRange\Models;

use Belamov\PostrgesRange\Casts\DateRangeCast;
use Belamov\PostrgesRange\Casts\FloatRangeCast;
use Belamov\PostrgesRange\Casts\IntegerRangeCast;
use Belamov\PostrgesRange\Casts\TimeRangeCast;
use Belamov\PostrgesRange\Casts\TimestampRangeCast;
use Belamov\PostrgesRange\Ranges\DateRange;
use Belamov\PostrgesRange\Ranges\FloatRange;
use Belamov\PostrgesRange\Ranges\IntegerRange;
use Belamov\PostrgesRange\Ranges\TimeRange;
use Belamov\PostrgesRange\Ranges\TimestampRange;
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
 * @package Belamov\PostrgesRange\Models
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
