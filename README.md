# Laravel package for PostgreSQL range types support

[![Latest Version on Packagist](https://img.shields.io/packagist/v/belamov/postgres-range.svg?style=flat-square)](https://packagist.org/packages/belamov/postgres-range)
![PHP from Packagist](https://img.shields.io/packagist/php-v/belamov/postgres-range)
![tests](https://github.com/belamov/postgres-range/workflows/tests/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/belamov/postgres-range/branch/master/graph/badge.svg)](https://codecov.io/gh/belamov/postgres-range)
[![StyleCI](https://github.styleci.io/repos/253326230/shield?branch=master)](https://github.styleci.io/repos/253326230)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/belamov/postgres-range/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/belamov/postgres-range/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/belamov/postgres-range.svg?style=flat-square)](https://packagist.org/packages/belamov/postgres-range)

This package provides support of PostgreSQL's range types for Laravel 7+.

## Problem

To better understand what problem does this package solve, I highly recommend to read [Date Ranges in Laravel](https://medium.com/@palypster/ranges-in-laravel-7-using-postgresql-c4bc69b91758) by [Pavol Perdík](https://github.com/palypster)

This package mostly just wraps all ideas introduced there

## Requirements

- Laravel >= 7
- PHP >= 7.4

## Installation

You can install the package via composer:

```bash
composer require belamov/postgres-range
```

## Available range types

- [daterange](#daterange)
- [tsrange](#tsrange)
- [numrange](#numrange)
- [int4range](#intrange)
- [int8range](#intrange)
- [custom timerange](#timerange)

### daterange

Let's imagine we want to use `daterange` column in our Laravel application.

First, let's add it in our migration files.

```php
public function up(): void
    {
        Schema::create(
            'table',
            static function (Blueprint $table) {
                $table->id();
                // ...
                $table->dateRange('date_range');
                // you can add any modifications
                // $table->dateRange('date_range')->nullable();
                // $table->dateRange('date_range')->default('[2010-01-01,2010-01-02)');
            }
        );
    }
``` 

Next, we should define cast for this column in our model class.

```php
use Belamov\PostgresRange\Casts\DateRangeCast;

class SomeModel extends Model
{
    // ...
    protected $casts = [
        'date_range' => DateRangeCast::class,
    ];
    // ...
}
```

Now, whenever we access `date_range` attribute in our model, it will return `Belamov\PostgresRange\Ranges\DateRange` instance

#### DateRange object

**_note that DateRange object is [automatically canonicalizable](#canonicalizable-ranges)_**

```php
use Belamov\PostgresRange\Ranges\DateRange;

$range = new DateRange('2010-01-10', '2010-01-15', '[', ')');

// note that you can initialize DateRange object either with strings,
// or with any objects that implement DateTime interface
// for example with Carbon objects
// $range = new DateRange(Carbon::parse('2010-01-10'), Carbon::now(), '[', ')')

$range->from(); // CarbonImmutable object
$range->to(); // CarbonImmutable object
(string) $range; // [2010-01-10,2010-01-15)

$model->update(['date_range' => $range]);
$model->date_range->from(); // CarbonImmutable object
$model->date_range->to(); // CarbonImmutable object
```

### tsrange

Let's imagine we want to use `tsrange` column in our Laravel application.

First, let's add it in our migration files.

```php
public function up(): void
    {
        Schema::create(
            'table',
            static function (Blueprint $table) {
                $table->id();
                // ...
                $table->timestampRange('timestamp_range');
                // you can add any modifications
                // $table->timestampRange('timestamp_range')->nullable();
                // $table->timestampRange('timestamp_range')->default('[2010-01-01 14:30:30,2010-01-02 14:30:30)');
            }
        );
    }
``` 

Next, we should define cast for this column in our model class.

```php
use Belamov\PostgresRange\Casts\TimestampRangeCast;

class SomeModel extends Model
{
    // ...
    protected $casts = [
        'timestamp_range' => TimestampRangeCast::class,
    ];
    // ...
}
```

Now, whenever we access `timestamp_range` attribute in our model, it will return `Belamov\PostgresRange\Ranges\TimestampRange` instance

#### TimestampRange object

```php
use Belamov\PostgresRange\Ranges\TimestampRange;

$range = new TimestampRange('2010-01-01 14:30:30', '2010-01-02 14:30:30', '[', ')');

// note that you can initialize TimestampRange object either with strings, 
// or with any objects that implement DateTime interface
// for example with Carbon objects
// $range = new TimestampRange(Carbon::parse('2010-01-01 14:30:30'), Carbon::now(), '[', ')')

$range->from(); // CarbonImmutable object
$range->to(); // CarbonImmutable object
(string) $range; // [2010-01-01 14:30:30,2010-01-02 14:30:30)

$model->update(['timestamp_range' => $range]);
$model->timestamp_range->from(); // CarbonImmutable object
$model->timestamp_range->to(); // CarbonImmutable object
```

### numrange

Let's imagine we want to use `numrange` column in our Laravel application.

First, let's add it in our migration files.

```php
public function up(): void
    {
        Schema::create(
            'table',
            static function (Blueprint $table) {
                $table->id();
                // ...
                $table->floatRange('float_range');
                // you can add any modifications
                // $table->timestampRange('float_range')->nullable();
                // $table->timestampRange('float_range')->default('[1.5,2.5)');
            }
        );
    }
``` 

Next, we should define cast for this column in our model class.

```php
use Belamov\PostgresRange\Casts\FloatRangeCast;

class SomeModel extends Model
{
    // ...
    protected $casts = [
        'float_range' => FloatRangeCast::class,
    ];
    // ...
}
```

Now, whenever we access `float_range` attribute in our model, it will return `Belamov\PostgresRange\Ranges\FloatRange` instance

#### FloatRange object

```php
use Belamov\PostgresRange\Ranges\FloatRange;

$range = new FloatRange(1.5, 2.5, '[', ')');

$range->from(); // 1.5
$range->to(); // 2.5
(string) $range; // [1.5,2.5)

$model->update(['float_range' => $range]);
$model->float_range->from(); // 1.5
$model->float_range->to(); // 2.5
```

### intrange

Let's imagine we want to use `int4range` or `int8range` column in our Laravel application.

First, let's add it in our migration files.

```php
public function up(): void
    {
        Schema::create(
            'table',
            static function (Blueprint $table) {
                $table->id();
                // ...
                $table->integerRange('integer_range'); //for int4range
                $table->bigIntegerRange('integer_range'); //for int8range

                // you can add any modifications
                // $table->integerRange('integer_range')->nullable();
                // $table->integerRange('integer_range')->default('[10,20)');
                // $table->bigIntegerRange('integer_range')->nullable();
                // $table->bigIntegerRange('integer_range')->default('[10,20)');
            }
        );
    }
``` 

Next, we should define cast for this column in our model class.

```php
use Belamov\PostgresRange\Casts\IntegerRangeCast;

class SomeModel extends Model
{
    // ...
    protected $casts = [
        'integer_range' => IntegerRangeCast::class,
    ];
    // ...
}
```

Now, whenever we access `integer_range` attribute in our model, it will return `Belamov\PostgresRange\Ranges\IntegerRange` instance

#### IntegerRange object

**_note that IntegerRange object is [automatically canonicalizable](#canonicalizable-ranges)_**

```php
use Belamov\PostgresRange\Ranges\IntegerRange;

$range = new IntegerRange(10, 20, '[', ')');

$range->from(); // 10
$range->to(); // 20
(string) $range; // [10,20)

$model->update(['integer_range' => $range]);
$model->integer_range->from(); // 10
$model->integer_range->to(); // 20
```


### timerange

Postgres doesn't support timerange type, so this package will define it.

Type definition happens whenever you call `$table->timeRange();` in your migration files.

But all sql scripts are idempotent, so if type is already defined they will not be executed.

Type definition implemented in this way:

```postgresql
CREATE OR REPLACE FUNCTION time_subtype_diff(x time, y time) RETURNS float8 AS
'SELECT EXTRACT(EPOCH FROM (x - y))' LANGUAGE sql STRICT IMMUTABLE;


DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'timerange') THEN
        CREATE TYPE timerange AS RANGE (
            subtype = time,
            subtype_diff = time_subtype_diff
        );
    END IF;
END$$
```

Type name and comparing function name are configurable:

- with env variables:
    ```
    TIMERANGE_TYPENAME=
    TIMERANGE_SUBTYPE_DIFF_FUNCTION_NAME=
    ```
- or with config file:
    ```bash
    php artisan vendor:publish --provider="Belamov\PostgresRange\PostgresRangeServiceProvider" --tag="config"
    ```
    in `config/postges-range.php`:
    ```php
    return [
        'timerange_typename' =>  'timerange',
        'timerange_subtype_diff_function_name' => 'time_subtype_diff',
    ];
    ```

Let's imagine we want to use that custom defined `timerange` type in our Laravel application.

First, let's add it in our migration files.

```php
public function up(): void
    {
        Schema::create(
            'table',
            static function (Blueprint $table) {
                $table->id();
                // ...
                $table->timeRange('time_range');

                // you can add any modifications
                // $table->timeRange('time_range')->nullable();
                // $table->timeRange('time_range')->default('[14:30:30,15:30:30)');
            }
        );
    }
``` 

Next, we should define cast for this column in our model class.

```php
use Belamov\PostgresRange\Casts\TimeRangeCast;

class SomeModel extends Model
{
    // ...
    protected $casts = [
        'time_range' => TimeRangeCast::class,
    ];
    // ...
}
```

Now, whenever we access `time_range` attribute in our model, it will return `Belamov\PostgresRange\Ranges\TimeRange` instance

#### TimeRange object

```php
use Belamov\PostgresRange\Ranges\TimeRange;

$range = new TimeRange('14:30:30', '15:30:30', '[', ')');

// note that you can initialize TimeRange object either with strings, 
// or with any objects that implement DateTime interface
// for example with Carbon objects
// $range = new TimestampRange(Carbon::parse('14:30:30'), Carbon::now(), '[', ')')

$range->from(); // '14:30:30'
$range->to(); // '15:30:30'
(string) $range; // '[14:30:30,15:30:30)'

$model->update(['time_range' => $range]);
$model->time_range->from(); // '14:30:30'
$model->time_range->to(); // '15:30:30'
```

## Querying

You can always use raw queries for interaction with range tipes like so:

```php
$query->whereRaw('range_column && ?', [$range]);
```

All `Range` objects will be correctly casted to strings

But for convenience this package provides a number of useful macros for query builder:

 | Macro                                                         | Posgres operator    | 
 | ------------------------------------------------------------- |:-------------------:| 
 | $query->whereRangeContains($left, $right)                     | @>                  |
 | $query->orWhereRangeContains($left, $right)                   | @>                  |
 | $query->whereRangeIsContainedBy($left, $right)                | <@                  |
 | $query->orWhereRangeIsContainedBy($left, $right)              | <@                  |
 | $query->whereRangeOverlaps($left, $right)                     | &&                  |
 | $query->orWhereRangeOverlaps($left, $right)                   | &&                  |
 | $query->whereRangeStrictlyLeftOf($left, $right)               | <<                  |
 | $query->orWhereRangeStrictlyLeftOf($left, $right)             | <<                  |
 | $query->whereRangeStrictlyRightOf($left, $right)              | >>                  |
 | $query->orWhereRangeStrictlyRightOf($left, $right)            | >>                  |
 | $query->whereRangeDoesNotExtendToTheRightOf($left, $right)    | &<                  |
 | $query->orWhereRangeDoesNotExtendToTheRightOf($left, $right)  | &<                  |
 | $query->whereRangeDoesNotExtendToTheLeftOf($left, $right)     | &>                  |
 | $query->orWhereRangeDoesNotExtendToTheLeftOf($left, $right)   | &>                  |
 | $query->whereRangeAdjacentTo($left, $right)                   | -&#124;-            |
 | $query->orWhereRangeAdjacentTo($left, $right)                 | -&#124;-            |

See [official postgres documentation](https://www.postgresql.org/docs/current/functions-range.html) for operators description

## Indexing

You can define index on range column with built in laravel function:

```php
Schema::table(
            'ranges',
            static function (Blueprint $table) {
                //...
                $table->spatialIndex('range_column');
            }
        );
```

## Exclude constraint

To add exclude constraint for excluding range column overlapping in your table you can use following syntax:

```php
Schema::table(
            'table',
            static function (Blueprint $table) {
                //...
                $table->excludeRangeOverlapping('range_column');
            }
        );
```

Note that you can provide multiple additional parameters for excluding range column overlapping only if other provided columns are equal:
```php
Schema::table(
            'table',
            static function (Blueprint $table) {
                //...
                $table->excludeRangeOverlapping('range_column', 'column1', 'column2', 'column3');
            }
        );
```

## Canonicalizable ranges

The built-in range types `int4range`, `int8range`, and `daterange` all use a canonical form that includes the lower bound and excludes the upper bound; that is, [). ([More in official documentation](https://www.postgresql.org/docs/9.3/rangetypes.html#RANGETYPES-DISCRETE))

So to reflect this behaviour [DateRange](#daterange-object) and [IntegerRange](#integerrange-object) object will be canonialize during initialization like so:

```php
// IntegerRange
$range = new IntegerRange(10, 20, '(', ')');
$range->from(); // 11
$range->to(); // 20
(string) $range; // '[11,20)'

$range = new IntegerRange(10, 20, '[', ']');
$range->from(); // 10
$range->to(); // 21
(string) $range; // '[10,21)'

//DateRange
$from = CarbonImmutable::parse('2010-01-10');
$to = CarbonImmutable::parse('2010-01-15');

$range = new DateRange($from, $to, '(', ')');
$range->from(); // equals $from->addDay()
$range->to(); // equals $to
(string) $range; // '[2010-01-11,2010-01-15)'

$range = new DateRange($from, $to, '[', ']');
$range->from(); // equals $from
$range->to(); // equals $to->addDay()
(string) $range; // '[2010-01-10,2010-01-16)'
```
## Note on extending PostgresGrammar

This package extends Laravel's `Illuminate\Database\Schema\Grammars\PostgresGrammar` and `Illuminate\Database\PostgresConnection` classes to provide fluent api for range columns in migrations.

If you are already extending any of this classes in your project, please consider extending them from `Belamov\PostgresRange\PostgresGrammarWithRangeTypes` or `Belamov\PostgresRange\PostgresGrammarWithRangeTypes` classes.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email business@belamov.com instead of using the issue tracker.

## Credits

- [belamov](https:belamov.com)
- [Date Ranges in Laravel](https://medium.com/@palypster/ranges-in-laravel-7-using-postgresql-c4bc69b91758) by [Pavol Perdík](https://github.com/palypster)
- [How to extend or overwrite Query Grammar in Laravel 5](https://medium.com/@daniilromazanov/how-to-extend-query-grammar-in-laravel-fb3d2d6de6d4) by Daniil Romazanov
- https://laravelpackage.com/ - great tutorial for developing packages for laravel
- [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.