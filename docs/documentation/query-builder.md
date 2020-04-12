# Query Builder support

You can always use raw queries for interaction with range tipes like so:

```php
$query->whereRaw('range_column && ?', [$range]);
```

All `Range` objects will be correctly casted to strings

But for convenience this package provides a number of useful macros for query builder:

 | Macro                                                   | Postgres operator   | 
 | ------------------------------------------------------- |:-------------------:| 
 | `whereRangeContains($left, $right)`                     | @>                  |
 | `orWhereRangeContains($left, $right)`                   | @>                  |
 | `whereRangeIsContainedBy($left, $right)`                | <@                  |
 | `orWhereRangeIsContainedBy($left, $right)`              | <@                  |
 | `whereRangeOverlaps($left, $right)`                     | &&                  |
 | `orWhereRangeOverlaps($left, $right)`                   | &&                  |
 | `whereRangeStrictlyLeftOf($left, $right)`               | <<                  |
 | `orWhereRangeStrictlyLeftOf($left, $right)`             | <<                  |
 | `whereRangeStrictlyRightOf($left, $right)`              | >>                  |
 | `orWhereRangeStrictlyRightOf($left, $right)`            | >>                  |
 | `whereRangeDoesNotExtendToTheRightOf($left, $right)`    | &<                  |
 | `orWhereRangeDoesNotExtendToTheRightOf($left, $right)`  | &<                  |
 | `whereRangeDoesNotExtendToTheLeftOf($left, $right)`     | &>                  |
 | `orWhereRangeDoesNotExtendToTheLeftOf($left, $right)`   | &>                  |
 | `whereRangeAdjacentTo($left, $right)`                   | -&#124;-            |
 | `orWhereRangeAdjacentTo($left, $right)`                 | -&#124;-            |

See [official postgres documentation](https://www.postgresql.org/docs/current/functions-range.html) for operators description
