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

    #[\Override]
    public function value(): int|float
    {
        return $this->result()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->result()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->result()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->result()->add($number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->result()->subtract($number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->result()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->result()->multiplyBy($number, ...$numbers);
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
        return $this->result()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->result()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->result()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->result()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->result()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->result()->squareRoot();
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
    public function result(): Number
    {
        if ($this->value < 2) {
            return Value::one;
        }

        $factorial = $i = $this->value;

        do {
            $factorial *= --$i;
        } while ($i > 1);

        return Real::of($factorial);
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this->result();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->value.'!';
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }
}
