<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Returns the first element that matches the specification or a default value
 *
 * @param iterable $items The collection
 * @param callable $callback The specification must return a boolean
 * @param mixed $default default value
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
 * @return mixed return the corresponding element or default value
 */
function first(iterable $items, callable $callback, $default = null, int $mode = CALLBACK_USE_VALUE)
{
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            return $value;
        }
    }

    return $default;
}
