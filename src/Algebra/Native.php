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
    private function __construct(private int|float|Value $value)
    {
    }

    /**
     * @psalm-pure
     */
    public static function of(int|float|Value $value): self
    {
        if ($value instanceof Value) {
            return new self($value);
        }

        if (\is_infinite($value)) {
            return new self($value > 0 ? Value::infinite : Value::negativeInfinite);
        }

        if (\is_nan($value)) {
            throw new NotANumber;
        }

        return new self(match ($value) {
            0, 0.0 => Value::zero,
            1, 1.0 => Value::one,
            2, 2.0 => Value::two,
            10, 10.0 => Value::ten,
            100, 100.0 => Value::hundred,
            \M_E => Value::e,
            \M_PI => Value::pi,
            default => $value,
        });
    }

    public function value(): int|float
    {
        if ($this->value instanceof Value) {
            return $this->value->value();
        }

        return $this->value;
    }

    #[\Override]
    public function raw(): self
    {
        return $this;
    }

    public function equals(self $number): bool
    {
        if ($this->value instanceof Value && $number->value instanceof Value) {
            return $this->value === $number->value;
        }

        return $this->value() == $number->value();
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        if ($this->value instanceof Value) {
            return $this->value->toString();
        }

        return \var_export($this->value, true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
