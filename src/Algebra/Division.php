<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZeroError;

final class Division implements Operation, Number
{
    private Number $dividend;
    private Number $divisor;
    private ?Number $result = null;

    public function __construct(Number $dividend, Number $divisor)
    {
        if ($divisor->equals(new Integer(0))) {
            throw new DivisionByZeroError;
        }

        $this->dividend = $dividend;
        $this->divisor = $divisor;
    }

    public function dividend(): Number
    {
        return $this->dividend;
    }

    public function divisor(): Number
    {
        return $this->divisor;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
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
        return new Addition($this, $number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return new Subtraction($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return new self($this, $number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return new Multiplication($this, $number, ...$numbers);
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
        return new Floor($this);
    }

    public function ceil(): Number
    {
        return new Ceil($this);
    }

    public function modulo(Number $modulus): Number
    {
        return new Modulo($this, $modulus);
    }

    public function absolute(): Number
    {
        return new Absolute($this);
    }

    public function power(Number $power): Number
    {
        return new Power($this, $power);
    }

    public function squareRoot(): Number
    {
        return new SquareRoot($this);
    }

    public function exponential(): Number
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): Number
    {
        return new BinaryLogarithm($this);
    }

    public function naturalLogarithm(): Number
    {
        return new NaturalLogarithm($this);
    }

    public function commonLogarithm(): Number
    {
        return new CommonLogarithm($this);
    }

    public function signum(): Number
    {
        return new Signum($this);
    }

    public function quotient(): Number
    {
        return $this->result();
    }

    public function result(): Number
    {
        return $this->result ??= Number\Number::wrap(
            $this->dividend->value() / $this->divisor->value()
        );
    }

    public function toString(): string
    {
        $dividend = $this->dividend instanceof Operation ?
            '('.$this->dividend->toString().')' : $this->dividend->toString();
        $divisor = $this->divisor instanceof Operation ?
            '('.$this->divisor->toString().')' : $this->divisor->toString();

        return sprintf(
            '%s ÷ %s',
            $dividend,
            $divisor
        );
    }
}
