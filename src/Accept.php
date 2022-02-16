<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Returns a subset of the collection with elements that match the specification.
 * The keys are preserved
 *
 * @param iterable $items The collection
 * @param callable $callback The specification is a callable that must return a boolean
 * @param int $mode [optional] <p>
 * Flag determining what arguments are sent to <i>callback</i>:
 * </p><ul>
 * <li>
 * <b>CALLBACK_USE_VALUE</b> - <b>default</b> pass value as the only argument
 * </li>
 * <li>
 * <b>CALLBACK_USE_KEY</b> - pass key as the only argument
 * to <i>callback</i> instead of the value</span>
 * </li>
 * <li>
 * <b>CALLBACK_USE_BOTH</b> - pass both value and key as
 * arguments to <i>callback</i></span>
 * </li>
 * </ul>
 * @return array
 */
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
