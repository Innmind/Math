<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
class Integer implements Number
{
    private int $value;

    final private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function of(int $value): self
    {
        if ($value > 0) {
            return self::positive($value);
        }

        if ($value < 0) {
            return new Integer\Negative($value);
        }

        return new self($value);
    }

    /**
     * @psalm-pure
     *
     * @param positive-int $value
     */
    public static function positive(int $value): Integer\Positive
    {
        return new Integer\Positive($value);
    }

    public function value(): int
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

    public function add(Number $number, Number ...$numbers): Number
    {
        return Addition::of($this, $number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return Subtraction::of($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
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

    public function factorial(): Factorial
    {
        return Factorial::of($this->value);
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

    public function increment(): self
    {
        return self::of($this->value + 1);
    }

    public function decrement(): self
    {
        return self::of($this->value - 1);
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
