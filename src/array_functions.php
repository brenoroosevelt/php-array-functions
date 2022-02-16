<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

function pull(array &$set, $key, $default = null)
{
    $value = $set[$key] ?? $default;
    unset($set[$key]);

    return $value;
}

function reindex(array &$items): void
{
    $items = array_values($items);
}

function all(iterable $items, callable $callback, bool $empty_is_valid = true, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        $count++;
        if (true !== call_user_func_array($callback, __args($mode, $key, $value))) {
            return false;
        }
    }

    return $empty_is_valid || $count > 0;
}

function some(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    return at_least(1, $items, $callback, $mode);
}

function none(iterable $items, callable $callback, int $mode = 0): bool
{
    return ! some($items, $callback, $mode);
}

function at_least(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
            if ($count >= $n) {
                return true;
            }
        }
    }

    return $count >= $n;
}

function at_most(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count <= $n;
}

function exactly(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count === $n;
}

function first(iterable $items, callable $callback, $default = null, int $mode = CALLBACK_USE_VALUE)
{
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            return $value;
        }
    }

    return $default;
}

function head(iterable $items, $default = null)
{
    foreach ($items as $value) {
        return $value;
    }

    return $default;
}

function map(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $result = [];
    foreach ($items as $key => $value) {
        $result[$key] = call_user_func_array($callback, __args($mode, $key, $value));
    }

    return $result;
}

function accept(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $result = [];
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function reject(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $result = [];
    foreach ($items as $key => $value) {
        if (true !== call_user_func_array($callback, __args($mode, $key, $value))) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function has(array $items, ...$keys): bool
{
    return ! array_diff($keys, array_keys($items));
}

function only(array $items, ...$keys): array
{
    return array_intersect_key($items, array_flip($keys));
}

function except(array $items, ...$keys): array
{
    return array_diff_key($items, array_flip($keys));
}

function column(iterable $items, $column): array
{
    $result = [];
    foreach ($items as $element) {
        if (is_array($element) && array_key_exists($column, $element)) {
            $result[] = $element[$column];
        }
    }

    return $result;
}

function paginate(array $items, int $page, int $per_page, bool $preserve_keys = true): array
{
    $offset = max(0, ($page - 1) * $per_page);

    return array_slice($items, $offset, $per_page, $preserve_keys);
}

function sum_values(iterable $items, callable $callback, int $mode = 0)
{
    $sum = 0;
    foreach ($items as $key => $value) {
        $sum += call_user_func_array($callback, __args($mode, $key, $value));
    }

    return $sum;
}

function count_values(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): int
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
        }
    }

    return $count;
}

function max_value(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE)
{
    $max = null;
    foreach ($items as $item) {
        $max = $item;

        break;
    }

    foreach ($items as $key => $value) {
        $value = call_user_func_array($callback, __args($mode, $key, $value));
        if ($value > $max) {
            $max = $value;
        }
    }

    return $max;
}

function min_value(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE)
{
    $min = null;
    foreach ($items as $item) {
        $min = $item;

        break;
    }

    foreach ($items as $key => $value) {
        $value = call_user_func_array($callback, __args($mode, $key, $value));
        if ($value < $min) {
            $min = $value;
        }
    }

    return $min;
}

function group_by(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $group = [];
    foreach ($items as $key => $value) {
        $group[call_user_func_array($callback, __args($mode, $key, $value))][] = $value;
    }

    return $group;
}
