# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/belamov/postgres-range.svg?style=flat-square)](https://packagist.org/packages/belamov/postgres-range)
![tests](https://github.com/belamov/postgres-range/workflows/tests/badge.svg)
[![codecov](https://codecov.io/gh/belamov/postgres-range/branch/master/graph/badge.svg)](https://codecov.io/gh/belamov/postgres-range)
[![StyleCI](https://github.styleci.io/repos/253326230/shield?branch=master)](https://github.styleci.io/repos/253326230)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/belamov/postgres-range/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/belamov/postgres-range/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/belamov/postgres-range.svg?style=flat-square)](https://packagist.org/packages/belamov/postgres-range)

This package provides support of PostgreSQL's range types for Laravel 7+.

## Installation

You can install the package via composer:

```bash
composer require belamov/postgres-range
```

## Usage

### Migrations

This package provides sql generator to add range columns. It generates `ALTER TABLE` statements to add new columns.
You can use it in your migration files

```php
use Belamov\PostgresRange\SqlGenerator;

$sqlGenerator = new SqlGenerator($tableName);
```

Available columns types are:
 - tsrange
    ```php
    $sqlGenerator->timestampRange(string $columnName, bool $nullable = false, ?string $default = null)
    ```
 - daterange
    ```php
    $sqlGenerator->dateRange(string $columnName, bool $nullable = false, ?string $default = null)
    ```
 - numrange
    ```php
    $sqlGenerator->numberRange(string $columnName, bool $nullable = false, ?string $default = null)
    ```
 - int4range
    ```php
    $sqlGenerator->integerRange(string $columnName, bool $nullable = false, ?string $default = null)
    ```
 - int8range
    ```php
    $sqlGenerator->bigintRange(string $columnName, bool $nullable = false, ?string $default = null)
    ```
 - custom timerange
 
    It will generate new type with default name `timerange`
    
    Following queries will be executed:
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
   END$$;
    ``` 
   
Also you can add indexes and unique constraints for column:
  -  gist index for range column
      ```php
      $sqlGenerator->gistIndex(string $columnName)
        ```
     It will execute following statement:
     ```postgresql
     CREATE INDEX ON table_name USING GIST (column_name)
     ```
  - unique constraint for range column
      ```php
        $sqlGenerator->unique(string $columnName)
      ```
    It will execute following statement:
     ```postgresql
     ALTER TABLE table_name
     ADD EXCLUDE USING GIST (column_name WITH &&);
     ```
  - unique constraint for range column with other columns
      ```php
        $sqlGenerator->unique(string $columnName, string $additionalColumn, ...)
      ```
    It will execute following statement:
     ```postgresql
    CREATE EXTENSION IF NOT EXISTS btree_gist;
    
     ALTER TABLE table_name
     ADD EXCLUDE USING GIST (additional_column WITH =, ..., column_name WITH &&);
     ```

### Models Casts

Next, add casts array elements to your Laravel models

```php
use Belamov\PostgresRange\Casts\DateRangeCast;
use Belamov\PostgresRange\Casts\FloatRangeCast;
use Belamov\PostgresRange\Casts\IntegerRangeCast;
use Belamov\PostgresRange\Casts\TimeRangeCast;
use Belamov\PostgresRange\Casts\TimestampRangeCast;

class Model extends Illuminate\Database\Eloquent\Model
{
    // ...
    protected $casts = [
        'timestamp_range' => TimestampRangeCast::class,
        'time_range' => TimeRangeCast::class,
        'float_range' => FloatRangeCast::class,
        'integer_range' => IntegerRangeCast::class,
        'bigint_range' => IntegerRangeCast::class,
        'date_range' => DateRangeCast::class
    ];
    // ...
}
```

Each column will be casted to matching `Range` object. 

All `Range` objects has two public methods: `to()` and `from()`. 

These methods will return matching types for each range type.

Note that `DateRange` and `IntegerRange` are automatically canonicalized, so they will be transformed to `[,)` boundaries. For details visit [oficial postgres documentation](https://www.postgresql.org/docs/9.3/rangetypes.html)

```php
$range = new FloatRange(1.5, 2.5, '[', ')');
$range->from(); //1.5
$range->to(); //2.5
(string)$range; // [1.5,2.5)

$range = new TimestampRange('2010-01-01 14:30:30', '2010-01-01 15:30:30', '[', ')');
$range->from(); // CarbonImmutable object
$range->to(); // CarbonImmutable object
(string)$range; // [2010-01-01 14:30:30,2010-01-01 15:30:30]

$range = new TimeRange('14:30', '15:30', '[', ')');
$range->from(); // '14:30:00'
$range->to(); // '15:30:00'
(string)$range; // [14:30,15:30)

$range = new IntegerRange(10, 20, '[', ')');
$range->from(); // 10
$range->to(); // 20
(string)$range; // [10,20)

$from = CarbonImmutable::parse('2010-01-10');
$to = CarbonImmutable::parse('2010-01-15');
$range = $range = new DateRange($from, $to, '[', ')');
$range->from(); // CarbonImmutable
$range->to(); // CarbonImmutable
(string)$range; // [10,20)
```
### Updating models
```php
use Belamov\PostgresRange\Ranges\IntegerRange;

$model->update(['integer_range' => new IntegerRange(10,20)]);
```
### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email business@belamov.com instead of using the issue tracker.

## Credits

- [belamov](https://github.com/belamov)
- [How to extend or overwrite Query Grammar in Laravel 5 article](https://medium.com/@daniilromazanov/how-to-extend-query-grammar-in-laravel-fb3d2d6de6d4) by Daniil Romazanov
- https://laravelpackage.com/
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).