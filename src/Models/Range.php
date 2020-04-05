<?php

namespace Belamov\PostrgesRange\Models;

use Belamov\PostrgesRange\Casts\DateRangeCast;
use Belamov\PostrgesRange\Casts\FloatRangeCast;
use Belamov\PostrgesRange\Casts\IntegerRangeCast;
use Belamov\PostrgesRange\Casts\TimeRangeCast;
use Belamov\PostrgesRange\Casts\TimestampRangeCast;
use Illuminate\Database\Eloquent\Model;

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
