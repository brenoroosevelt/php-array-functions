# PHP Array Functions

[![CI Build](https://github.com/brenoroosevelt/php-array-functions/actions/workflows/ci.yml/badge.svg)](https://github.com/brenoroosevelt/php-array-functions/actions/workflows/ci.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brenoroosevelt/php-array-functions/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/brenoroosevelt/php-array-functions/?branch=main)
[![codecov](https://codecov.io/gh/brenoroosevelt/php-array-functions/branch/main/graph/badge.svg?token=S1QBA18IBX)](https://codecov.io/gh/brenoroosevelt/php-array-functions)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)

A set of helpful functions that are missing in PHP.

## Requirements

The following versions of PHP are supported: `7.4`, `8.0`, `8.1`.

## Install

```bash
$ composer require brenoroosevelt/array-functions
```

## Usage

### index_of
```php
/**
 * Searches the iterable for a given element and returns the first corresponding key (index) if successful
 *
 * @param iterable $haystack The iterable collection
 * @param mixed $element The searched element
 * @param bool $strict If the third parameter strict is set to true then will also check the types of the needle
 * @return false|int|string the key for needle if it is found in the array, false otherwise.
 */
function index_of(iterable $haystack, $element, bool $strict = true)
```

### contains
```php
/**
 * Checks if ALL elements exists in a collection
 * The element index (key) is irrelevant for this operation
 *
 * @param iterable $items The collection
 * @param mixed ...$elements The searched elements
 * @return bool True if ALL elements were found in the collection, false otherwise
 */
function contains(iterable $items, ...$elements): bool
```

### add
```php
/**
 * Adds elements to a collection if they don't exist yet (set behavior).
 * The element index (key) is irrelevant for this operation
 * 
 * @param array $set The collection
 * @param mixed ...$elements Elements to be added
 * @return int The number of items added to the collection
 */
function add(array &$set, ...$elements): int
```

### set
```php
/**
 * Adds or replace an element to a collection using an optional key/index.
 * If the given key already exists in the collection, the corresponding value will be replaced by the element
 *
 * @example $set = ['a' => 1, 2, 3, 4]
 * set($set, 2, 'a') $set will contain ['a' => 2, 2, 3, 4]
 *
 * @example $set = ['a' => 1, 2, 3, 4]
 * set($set, 1) $set will contain ['a' => 1, 2, 3, 4, 1]
 *
 * @param array $set The collection
 * @param mixed $element The element to be added
 * @param string|int $key The key/index of element
 * @return void
 */
function set(array &$set, $element, $key = null): void
```

### remove
```php
/**
 * Remove all provided elements from the collection
 * The element index (key) is irrelevant for this operation
 * This function uses strict comparison to find and remove elements
 *
 * @example $set = [1, 1, 2, 3, 4]
 * remove($set, 1, 3) will return 3 (int) and $set will contain [2, 4]
 * 
 * @param array $set The collection
 * @param mixed ...$elements Elements to be removed
 * @return int The number of removed elements
 */
function remove(array &$set, ...$elements): int
```

## License

This project is licensed under the terms of the MIT license. See the [LICENSE](LICENSE.md) file for license rights and limitations.
