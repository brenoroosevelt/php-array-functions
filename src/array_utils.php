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
    return !array_some($array, $callback);
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

function array_first(iterable $array, callable $callback, $default = null)
{
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            return $value;
        }
    }

    return $default;
}

function array_map(iterable $array, callable $callback, bool $preserveKeys = true): array
{
    $result = [];
    foreach ($array as $key => $value) {
        $mapped = call_user_func_array($callback, [$value, $key]);
        if ($preserveKeys) {
            $result[$key] = $mapped;
        } else {
            $result[] = $mapped;
        }
    }

    return $result;
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

function array_accept(iterable $array, callable $callback, bool $preserveKeys = true): array
{
    $result = [];
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            if ($preserveKeys) {
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function array_reject(iterable $array, callable $callback, bool $preserveKeys = true): array
{
    return array_accept($array, fn ($v, $k) => !call_user_func_array($callback, [$v, $k]), $preserveKeys);
}

function index_of(iterable $array, $element, bool $strict = true)
{
    if (is_array($array)) {
        return array_search($element, $array, $strict);
    }

    foreach ($array as $index => $value) {
        if (($strict === true && $element === $value) ||
            ($strict === false && $element == $value)
        ) {
            return $index;
        }
    }

    return false;
}

function array_remove_first(array &$array, $element, bool $strict = true): bool
{
    $index = index_of($array, $element, $strict);
    if ($index !== false) {
        unset($array[$index]);

        return true;
    }

    return false;
}

function array_remove_all(array &$array, $element, bool $strict = true): int
{
    $removed = 0;
    while (false !== ($index = index_of($array, $element, $strict))) {
        unset($array[$index]);
        $removed++;
    }

    return $removed;
}
