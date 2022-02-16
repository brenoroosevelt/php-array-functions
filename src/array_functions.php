<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

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
