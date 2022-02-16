<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

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

function sum(iterable $items, callable $callback, int $mode = 0)
{
    $sum = 0;
    foreach ($items as $key => $value) {
        $sum += call_user_func_array($callback, __args($mode, $key, $value));
    }

    return $sum;
}
