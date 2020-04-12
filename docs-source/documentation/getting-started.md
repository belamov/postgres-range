# Getting started

## Problem

To better understand what problem does this package solve, 
I highly recommend to read [Date Ranges in Laravel](https://medium.com/@palypster/ranges-in-laravel-7-using-postgresql-c4bc69b91758) 
by [Pavol Perdík](https://github.com/palypster)

This package mostly just wraps all ideas introduced there, but adds support for other range types and custom `timerange` type

## Requirements

- Laravel >= 7
- PHP >= 7.4

## Installation

You can install the package via composer:

```bash
composer require belamov/postgres-range
```

## Note on extending `PostgresGrammar`

This package extends Laravel's `Illuminate\Database\Schema\Grammars\PostgresGrammar` and `Illuminate\Database\PostgresConnection` classes
 to provide fluent api for range columns in migrations.

If you are already extending any of this classes in your project, 
please consider extending your implementation from 
`Belamov\PostgresRange\PostgresGrammarWithRangeTypes` or `Belamov\PostgresRange\PostgresGrammarWithRangeTypes` classes.