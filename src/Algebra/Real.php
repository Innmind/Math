<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\NotANumber;

/**
 * @psalm-immutable
 * @internal
 */
final class Real implements Implementation
{
    private float $value;

    private function __construct(float $value)
    {
        if (\is_nan($value)) {
            throw new NotANumber;
        }

        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function of(int|float $value): Implementation
    {
        if (\is_infinite($value)) {
            return $value > 0 ? Value::infinite : Value::negativeInfinite;
        }

        if (\is_int($value)) {
            return Integer::of($value);
        }

        return new self($value);
    }

    #[\Override]
    public function value(): float
    {
        return $this->value;
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value == $number->value();
    }

    #[\Override]
    public function collapse(): Implementation
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        return \var_export($this->value, true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
