# Available range types

[[toc]]

## daterange

Let's imagine we want to use `daterange` column in our Laravel application.

### Migrations

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

### Model property casting

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

Now, whenever we access `date_range` attribute in our model, 
it will return `Belamov\PostgresRange\Ranges\DateRange` instance

### DateRange object

::: warning
DateRange object is [automatically canonicalizable](#canonicalizable-ranges)
:::

Initialization:

```php
use Belamov\PostgresRange\Ranges\DateRange;

$range = new DateRange('2010-01-10', '2010-01-15', '[', ')');
```

::: tip
Note that you can initialize `DateRange` object either with strings,
or with any objects that implement `DateTime` interface
for example with `Carbon `objects
```php
$range = new DateRange(Carbon::parse('2010-01-10'), Carbon::now(), '[', ')')
```
:::

API:

```php
$range->from(); // CarbonImmutable object
$range->to(); // CarbonImmutable object
(string) $range; // [2010-01-10,2010-01-15)
```
Updating or creating model:
```php
$model->update(['date_range' => $range]);
$model->date_range; // DateRange object
$model->date_range->from(); // CarbonImmutable object
$model->date_range->to(); // CarbonImmutable object
```

## tsrange

Let's imagine we want to use `tsrange` column in our Laravel application.

### Migrations

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

### Model property casting

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

### TimestampRange object

Initialization:

```php
use Belamov\PostgresRange\Ranges\TimestampRange;

$range = new TimestampRange('2010-01-01 14:30:30', '2010-01-02 14:30:30', '[', ')');
```

::: tip
Note that you can initialize TimestampRange object either with strings, 
or with any objects that implement DateTime interface
for example with Carbon objects
```php
$range = new TimestampRange(Carbon::parse('2010-01-01 14:30:30'), Carbon::now(), '[', ')')
```
:::

API:

```php
$range->from(); // CarbonImmutable object
$range->to(); // CarbonImmutable object
(string) $range; // [2010-01-01 14:30:30,2010-01-02 14:30:30)
```

Model updating or creating:
```php
$model->update(['timestamp_range' => $range]);
$model->timestamp_range; // TimestampRange object
$model->timestamp_range->from(); // CarbonImmutable object
$model->timestamp_range->to(); // CarbonImmutable object
```

## numrange

Let's imagine we want to use `numrange` column in our Laravel application.

### Migrations

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

### Model property casting

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

### FloatRange object

Initialization:

```php
use Belamov\PostgresRange\Ranges\FloatRange;

$range = new FloatRange(1.5, 2.5, '[', ')');
```

API:

```php
$range->from(); // 1.5
$range->to(); // 2.5
(string) $range; // [1.5,2.5)
```

Model updating or creating:

```php
$model->update(['float_range' => $range]);
$model->float_range; // FloatRange object
$model->float_range->from(); // 1.5
$model->float_range->to(); // 2.5
```

## intrange

Let's imagine we want to use `int4range` or `int8range` column in our Laravel application.

### Migrations

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

### Model property casting

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

### IntegerRange object

::: warning
IntegerRange object is [automatically canonicalizable](#canonicalizable-ranges)
:::

Initialization:

```php
use Belamov\PostgresRange\Ranges\IntegerRange;

$range = new IntegerRange(10, 20, '[', ')');
```

API:

```php
$range->from(); // 10
$range->to(); // 20
(string) $range; // [10,20)
```

Model updating or creating:
```php
$model->update(['integer_range' => $range]);
$model->integer_range; // IntegerRange object
$model->integer_range->from(); // 10
$model->integer_range->to(); // 20
```


## timerange

Postgres doesn't support timerange type, so this package will define it.

Type definition happens whenever you call `$table->timeRange();` in your migration files.

But all sql scripts are idempotent, so this scripts may be run multiple times.

Type definition implemented in this way:

```sql
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
    TIMERANGE_TYPENAME=timerange
    TIMERANGE_SUBTYPE_DIFF_FUNCTION_NAME=time_subtype_diff
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

### Migrations

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

### Model property casting

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

### TimeRange object

Initialization:

```php
use Belamov\PostgresRange\Ranges\TimeRange;

$range = new TimeRange('14:30:30', '15:30:30', '[', ')');
```

::: tip
Note that you can initialize `TimeRange` object either with strings, 
or with any objects that implement `DateTime` interface
for example with `Carbon` objects
```php
$range = new TimestampRange(Carbon::parse('14:30:30'), Carbon::now(), '[', ')')
```
:::

API:

```php
$range->from(); // '14:30:30'
$range->to(); // '15:30:30'
(string) $range; // '[14:30:30,15:30:30)'
```

Model updating or creating:

```php
$model->update(['time_range' => $range]);
$model->time_range; // TimeRange object
$model->time_range->from(); // '14:30:30'
$model->time_range->to(); // '15:30:30'
```

## Canonicalizable ranges

The built-in range types `int4range`, `int8range`, and `daterange` all use a canonical form that includes the lower bound and excludes the upper bound; that is, [). ([More in official documentation](https://www.postgresql.org/docs/9.3/rangetypes.html#RANGETYPES-DISCRETE))

So to reflect this behaviour [DateRange](#daterange-object) and [IntegerRange](#integerrange-object) object will be canonialized during initialization like so:

When lower boundary is exclusive:

```php
$range = new IntegerRange(10, 20, '(', ')');
$range->from(); // 11
$range->to(); // 20
(string) $range; // '[11,20)'

$range = new DateRange($from, $to, '(', ')');
$range->from(); // equals $from->addDay()
$range->to(); // equals $to
(string) $range; // '[2010-01-11,2010-01-15)'
```

When upper boundary is inclusive:

```php
$range = new IntegerRange(10, 20, '[', ']');
$range->from(); // 10
$range->to(); // 21
(string) $range; // '[10,21)'

$range = new DateRange($from, $to, '[', ']');
$range->from(); // equals $from
$range->to(); // equals $to->addDay()
(string) $range; // '[2010-01-10,2010-01-16)'
```