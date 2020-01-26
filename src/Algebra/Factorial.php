<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\FactorialMustBePositive;

final class Factorial implements Operation, Number
{
    private int $value;
    private ?Number $number = null;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new FactorialMustBePositive((string) $value);
        }

        $this->value = $value;
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
        return $this->result()->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->result()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->result()->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->result()->multiplyBy($number, ...$numbers);
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
        return $this->result()->floor();
    }

    public function ceil(): Number
    {
        return $this->result()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->result()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->result()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->result()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->result()->squareRoot();
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

    public function result(): Number
    {
        if ($this->number) {
            return $this->number;
        }

        if ($this->value < 2) {
            return $this->number = new Integer(1);
        }

        $factorial = $i = $this->value;

        do {
            $factorial *= --$i;
        } while ($i > 1);

        return $this->number = Number\Number::wrap($factorial);
    }

    public function toString(): string
    {
        return $this->value.'!';
    }
}
