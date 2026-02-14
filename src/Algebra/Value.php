<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
enum Value implements Implementation
{
    case zero;
    case one;
    case two;
    case ten;
    case hundred;
    /** 1/0! + 1/1! + 1/2! + 1/3! + ... + 1/n! */
    case e;
    case pi;
    case infinite;
    case negativeInfinite;

    #[\Override]
    public function value(): int|float
    {
        return match ($this) {
            self::zero => 0,
            self::one => 1,
            self::two => 2,
            self::ten => 10,
            self::hundred => 100,
            self::e => \M_E,
            self::pi => \M_PI,
            self::infinite => \INF,
            self::negativeInfinite => -\INF,
        };
    }

    public function equals(Native|self $number): bool
    {
        if ($number instanceof self) {
            return $this === $number;
        }

        return $number->equals($this);
    }

    #[\Override]
    public function raw(): Native|Value
    {
        return $this;
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        return match ($this) {
            self::zero => '0',
            self::one => '1',
            self::two => '2',
            self::ten => '10',
            self::hundred => '100',
            self::e => 'e',
            self::pi => 'π',
            self::infinite => '+∞',
            self::negativeInfinite => '-∞',
        };
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
