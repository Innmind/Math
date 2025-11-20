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

    #[\Override]
    public function value(): float
    {
        return $this->value;
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
    public function add(Number $number): Number
    {
        return Addition::of($this, $number);
    }

    #[\Override]
    public function subtract(Number $number): Number
    {
        return Subtraction::of($this, $number);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    #[\Override]
    public function multiplyBy(Number $number): Number
    {
        return Multiplication::of($this, $number);
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
        return \var_export($this->value, true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
