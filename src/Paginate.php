<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Returns array pagination
 * If <b>page</b> or <b>per_page</b> is less than 1, this function will return empty array
 *
 * @param array $items The array to be paginated
 * @param int $page The page number (first page is `1`)
 * @param int $per_page Number of elements per page
 * @param bool $preserve_keys Preserve keys
 * @return array
 */
function paginate(array $items, int $page, int $per_page, bool $preserve_keys = true): array
{
    if ($per_page < 1 || $page < 1) {
        return [];
    }

    $offset = max(0, ($page - 1) * $per_page);

    return array_slice($items, $offset, $per_page, $preserve_keys);
}
