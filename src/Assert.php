<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

use AssertionError;
use Throwable;

final class Assert
{
    private array $values = [];

    public static function that(...$values): self
    {
        $assert = new self;
        $assert->values = $values;

        return $assert;
    }

    /**
     * @param callable|bool $constraint
     * @param Throwable|string $error
     * @return $this
     * @throws AssertionError
     */
    public function is($constraint, $error = 'Invalid input'): self
    {
        $is_valid = is_bool($constraint) ? $constraint : call_user_func_array($constraint, $this->values);
        if (! $is_valid) {
            throw $error instanceof Throwable ? $error : new AssertionError(is_string($error) ? $error : '');
        }

        return $this;
    }
}
