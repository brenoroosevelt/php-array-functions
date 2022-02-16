# PHP Array Functions

[![CI Build](https://github.com/brenoroosevelt/php-array-functions/actions/workflows/ci.yml/badge.svg)](https://github.com/brenoroosevelt/php-array-functions/actions/workflows/ci.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brenoroosevelt/php-array-functions/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/brenoroosevelt/php-array-functions/?branch=main)
[![codecov](https://codecov.io/gh/brenoroosevelt/php-array-functions/branch/main/graph/badge.svg?token=S1QBA18IBX)](https://codecov.io/gh/brenoroosevelt/php-array-functions)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)

A set of helpful array/iterables functions.

## Requirements

The following versions of PHP are supported: `7.4`, `8.0`, `8.1`.

## Install

```bash
$ composer require brenoroosevelt/array-functions
```

```php
// Add - Set
function add(array &$set, ...$elements): int
function set(array &$set, $element, $key = null): void

// Count
function all(iterable $items, callable $callback, bool $empty_is_valid = true, int $mode = CALLBACK_USE_VALUE): bool
function at_least(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
function at_most(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
function exactly(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
function none(iterable $items, callable $callback, int $mode = 0): bool
function some(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
function contains(iterable $items, ...$elements): bool

// Filter - Extract
function accept(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
function reject(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
function only(array $items, ...$keys): array
function except(array $items, ...$keys): array
function first(iterable $items, callable $callback, $default = null, int $mode = CALLBACK_USE_VALUE)

// Key - Index
function has(array $haystack, $key, ...$keys): bool
function index_of(iterable $haystack, $element, bool $strict = true)

// Remove - Pull
function pull(array &$set, $key, $default = null)
function remove(array &$set, ...$elements): int
function remove_key(array &$set, $key, ...$keys): int

// Miscellaneous
function map(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
function paginate(array $items, int $page, int $per_page, bool $preserve_keys = true): array
function sum(iterable $items, callable $callback, int $mode = 0)

// Dot Notation
function flatten(array $items, ?string $pathSeparator = null): array
function expand(array $items, string $separator = '.'): array
function set_path(array &$haystack, string $path, $value, string $separator = '.'): void
function get_path(array $haystack, string $path, $default = null, string $separator = '.')
function unset_path(array &$haystack, string $path, string $separator = '.')
function has_path(array $haystack, string $path, string $separator = '.'): bool

// Pipeline
function pipe($payload, callable ...$stages)
function with(&$value, callable ...$jobs)
```
## License

This project is licensed under the terms of the MIT license. See the [LICENSE](LICENSE.md) file for license rights and limitations.
