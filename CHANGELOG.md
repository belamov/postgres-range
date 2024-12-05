# Changelog

All notable changes to `postrges-range` will be documented in this file

## [Unreleased]

## [1.2.3] - 2024-03-22

### Added

- Added support for PHP 8.4: [Implicitly nullable parameter declarations deprecated](https://php.watch/versions/8.4/implicitly-marking-parameter-type-nullable-deprecated) [@isalcedo](https://github.com/isalcedo)

## [1.2.2] - 2024-03-22

### Added

- Update laravel to v11 and other composer dependencies by [@Arthur-Sk](https://github.com/Arthur-Sk)

## [1.2.1] - 2023-02-16

### Added

- added support for laravel 10

## [1.2.0] - 2022-12-06

### Added

- added getters for boundaries by [@lunain84](https://github.com/lunain84)

## [1.1.3] - 2022-02-08

### Added

- support for laravel 9

## [1.1.2] - 2021-11-07

### Added

- updated github workflow strategy

## [1.1.1] - 2020-12-07

### Added

- support for php 8

## [1.1.0] - 2020-09-26

### Added

- hasLowerBoundary and hasUpperBoundary methods to range objects
- tstzrange support 

## [1.0.4] - 2020-09-11

### Added

- laravel 8 support

## [1.0.3] - 2020-09-01

### Fixed

- empty boundaries not returning null

## [1.0.2] - 2020-04-25

### Fixed

- RangeRangeOverlaps macro typo [@resohead](https://github.com/resohead)

## [1.0.1] - 2020-04-23

### Added

- helper scripts for development
- docker dev environment
- moved docs to vuepress

### Fixed

- macros

## [1.0.0] - 2020-04-10

### Added

- support of range types for laravel

[unreleased]: https://github.com/belamov/postgres-range/compare/1.1.0...HEAD
[1.1.1]: https://github.com/belamov/postgres-range/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/belamov/postgres-range/compare/1.0.4...1.1.0
[1.0.4]: https://github.com/belamov/postgres-range/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/belamov/postgres-range/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/belamov/postgres-range/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/belamov/postgres-range/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/belamov/postgres-range/releases/tag/1.0.0
