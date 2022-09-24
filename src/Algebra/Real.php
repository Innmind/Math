<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\NotANumber;

/**
 * @psalm-immutable
 */
final class Real implements Number
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
    public static function of(int|float $value): Number
    {
        if (\is_infinite($value)) {
            return $value > 0 ? Value::infinite : Value::negativeInfinite;
        }

        if (\is_int($value)) {
            return Integer::of($value);
        }

        return new self($value);
    }

    public function value(): float
    {
        return $this->value;
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
        return \var_export($this->value, true);
    }
}
