<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZero;

/**
 * @psalm-immutable
 */
final class Division implements Operation, Number
{
    private Number $dividend;
    private Number $divisor;

    private function __construct(Number $dividend, Number $divisor)
    {
        if ($divisor->equals(Value::zero)) {
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

    public function value(): int|float
    {
        return $this->result()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->result()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->result()->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return Addition::of($this, $number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return Subtraction::of($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): self
    {
        return new self($this, $number);
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

    public function quotient(): Number
    {
        return $this->result();
    }

    public function result(): Number
    {
        return $this->compute(
            $this->dividend,
            $this->divisor,
        );
    }

    public function collapse(): Number
    {
        return $this->compute(
            $this->dividend->collapse(),
            $this->divisor->collapse(),
        );
    }

    public function toString(): string
    {
        $dividend = $this->dividend instanceof Operation ?
            '('.$this->dividend->toString().')' : $this->dividend->toString();
        $divisor = $this->divisor instanceof Operation ?
            '('.$this->divisor->toString().')' : $this->divisor->toString();

        return \sprintf(
            '%s ÷ %s',
            $dividend,
            $divisor,
        );
    }

    private function compute(Number $dividend, Number $divisor): Number
    {
        return Number\Number::of(
            $dividend->value() / $divisor->value(),
        );
    }
}
