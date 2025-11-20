<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZero;

/**
 * @psalm-immutable
 */
final class Division implements Number
{
    private Number $dividend;
    private Number $divisor;

    private function __construct(Number $dividend, Number $divisor)
    {
        if ($divisor->collapse()->equals(Value::zero)) {
            throw new DivisionByZero;
        }

        $this->dividend = $dividend;
        $this->divisor = $divisor;
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $dividend, Number $divisor): self
    {
        return new self($dividend, $divisor);
    }

    public function dividend(): Number
    {
        return $this->dividend;
    }

    public function divisor(): Number
    {
        return $this->divisor;
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->quotient()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->quotient()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->quotient()->higherThan($number);
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
    public function divideBy(Number $number): self
    {
        return new self($this, $number);
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

    public function quotient(): Number
    {
        return $this->compute(
            $this->dividend,
            $this->divisor,
        );
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this->compute(
            $this->dividend->collapse(),
            $this->divisor->collapse(),
        );
    }

    #[\Override]
    public function toString(): string
    {
        $dividend = $this->dividend->format();
        $divisor = $this->divisor->format();

        return \sprintf(
            '%s ÷ %s',
            $dividend,
            $divisor,
        );
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function compute(Number $dividend, Number $divisor): Number
    {
        return Real::of(
            $dividend->value() / $divisor->value(),
        );
    }
}
