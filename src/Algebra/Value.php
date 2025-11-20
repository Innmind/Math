<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
enum Value implements Number
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

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->value() == $number->collapse()->value();
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->value() > $number->collapse()->value();
    }

    #[\Override]
    public function add(
        Number $number,
        Number ...$numbers,
    ): Number {
        return Addition::of($this, $number, ...$numbers);
    }

    #[\Override]
    public function subtract(
        Number $number,
        Number ...$numbers,
    ): Number {
        return Subtraction::of($this, $number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    #[\Override]
    public function multiplyBy(
        Number $number,
        Number ...$numbers,
    ): Number {
        return Multiplication::of($this, $number, ...$numbers);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return Round::up($this, $precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return Round::down($this, $precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return Round::even($this, $precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return Round::odd($this, $precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return Floor::of($this);
    }

    #[\Override]
    public function ceil(): Number
    {
        return Ceil::of($this);
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return Modulo::of($this, $modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return Absolute::of($this);
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return Power::of($this, $power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return SquareRoot::of($this);
    }

    #[\Override]
    public function exponential(): Number
    {
        return Exponential::of($this);
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return BinaryLogarithm::of($this);
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return NaturalLogarithm::of($this);
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return CommonLogarithm::of($this);
    }

    #[\Override]
    public function signum(): Number
    {
        return Signum::of($this);
    }

    #[\Override]
    public function collapse(): Number
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
