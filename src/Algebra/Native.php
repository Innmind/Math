<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\NotANumber;

/**
 * @psalm-immutable
 * @internal
 */
final class Native implements Implementation
{
    private function __construct(private int|float $value)
    {
    }

    /**
     * @psalm-pure
     */
    public static function of(int|float $value): Implementation
    {
        if (\is_infinite($value)) {
            return $value > 0 ? Value::infinite : Value::negativeInfinite;
        }

        if (\is_nan($value)) {
            throw new NotANumber;
        }

        return match ($value) {
            0 => Value::zero,
            1 => Value::one,
            2 => Value::two,
            10 => Value::ten,
            100 => Value::hundred,
            \M_E => Value::e,
            \M_PI => Value::pi,
            default => new self($value),
        };
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->value;
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value == $number->value();
    }

    #[\Override]
    public function optimize(): Implementation
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
