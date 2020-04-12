# Indexes and constraints

## Indexing

You can define index on range column with built in Laravel function:

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

To add exclude constraint for excluding range column overlapping 
in your table you can use following syntax:

```php
Schema::table(
            'table',
            static function (Blueprint $table) {
                //...
                $table->excludeRangeOverlapping('range_column');
            }
        );
```

Note that you can provide any additional parameters 
for excluding range column overlapping only if other provided columns are equal:

```php
Schema::table(
            'table',
            static function (Blueprint $table) {
                //...
                $table->excludeRangeOverlapping('range_column', 'column1', 'column2', 'column3');
            }
        );
```
