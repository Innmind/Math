<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\FactorialMustBePositive;

/**
 * @psalm-immutable
 */
final class Factorial implements Operation, Number
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new FactorialMustBePositive((string) $value);
        }

        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function of(int $value): self
    {
        return new self($value);
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

    public function result(): Number
    {
        if ($this->value < 2) {
            return Value::one;
        }

        $factorial = $i = $this->value;

        do {
            $factorial *= --$i;
        } while ($i > 1);

        return Number\Number::of($factorial);
    }

    public function collapse(): Number
    {
        return $this->result();
    }

    public function toString(): string
    {
        return $this->value.'!';
    }
}
