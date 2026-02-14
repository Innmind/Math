<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
enum Value
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

    /**
     * This allows to safely check if numbers are this integer without computing
     * the real value.
     */
    public function is(Implementation $number): bool
    {
        if ($number instanceof Native) {
            return $number->is($this);
        }

        // todo allow to optimize on addition, multiplication and subtraction ?
        // this could be checked if each component is an int but the
        // recursiveness can be expansive to walk through

        // other than zero through hundred we prevent optimizing
        return false;
    }

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
}
