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

    public function equals(Number $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(Number $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(
        Number $number,
        Number ...$numbers,
    ): Number {
        return Addition::of($this, $number, ...$numbers);
    }

    public function subtract(
        Number $number,
        Number ...$numbers,
    ): Number {
        return Subtraction::of($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    public function multiplyBy(
        Number $number,
        Number ...$numbers,
    ): Number {
        return Multiplication::of($this, $number, ...$numbers);
    }

    public function roundUp(int $precision = 0): Number
    {
        return Round::up($this, $precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return Round::down($this, $precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return Round::even($this, $precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return Round::odd($this, $precision);
    }

    public function floor(): Number
    {
        return Floor::of($this);
    }

    public function ceil(): Number
    {
        return Ceil::of($this);
    }

    public function modulo(Number $modulus): Number
    {
        return Modulo::of($this, $modulus);
    }

    public function absolute(): Number
    {
        return Absolute::of($this);
    }

    public function power(Number $power): Number
    {
        return Power::of($this, $power);
    }

    public function squareRoot(): Number
    {
        return SquareRoot::of($this);
    }

    public function exponential(): Number
    {
        return Exponential::of($this);
    }

    public function binaryLogarithm(): Number
    {
        return BinaryLogarithm::of($this);
    }

    public function naturalLogarithm(): Number
    {
        return NaturalLogarithm::of($this);
    }

    public function commonLogarithm(): Number
    {
        return CommonLogarithm::of($this);
    }

    public function signum(): Number
    {
        return Signum::of($this);
    }

    public function collapse(): Number
    {
        return $this;
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
