<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

use Throwable;

class Validate
{
    private $value;
    private array $errors;

    final public function __construct($value, string ...$errors)
    {
        $this->value = $value;
        $this->errors = $errors;
    }

    public static function value($value): self
    {
        return new self($value);
    }

    /**
     * @param callable|bool $constraint
     * @param Throwable|string $error
     * @return $this
     */
    public function is($constraint, string $error = 'Invalid input'): self
    {
        $is_valid = is_bool($constraint) ? $constraint : call_user_func_array($constraint, $this->values);

        return $is_valid ? $this : new self($this->value, ...$this->errors, $error);
    }

    /** @return string[] */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isOk(): bool
    {
        return count($this->errors) === 0;
    }
}
