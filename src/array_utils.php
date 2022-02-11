<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

function array_all(iterable $array, callable $callback): bool
{
    foreach ($array as $key => $value) {
        if (true !== call_user_func_array($callback, [$value, $key])) {
            return false;
        }
    }

    return true;
}

function array_some(iterable $array, callable $callback): bool
{
    return array_at_least($array, 1, $callback);
}

function array_none(iterable $array, callable $callback): bool
{
    return ! array_some($array, $callback);
}

function array_at_least(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
            if ($count >= $n) {
                return true;
            }
        }
    }

    return false;
}

function array_at_most(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return true;
}

function array_exactly(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count === $n;
}

function array_first(iterable $array, callable $callback, $default = null): bool
{
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            return $value;
        }
    }

    return $default;
}

function array_each(iterable $array, callable $callback, bool $stoppable = true): void
{
    foreach ($array as $key => $value) {
        $result = call_user_func_array($callback, [$value, $key]);
        if ($result !== true && $stoppable) {
            break;
        }
    }
}
