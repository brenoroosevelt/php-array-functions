<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Evaluates if some matches the specification
 *
 * @param iterable $items The collection
 * @param callable $callback Callable must return a boolean
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
 * @return bool
 */
function some(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    return at_least(1, $items, $callback, $mode);
}
