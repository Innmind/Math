<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

final class Integer implements Number
{
    private Number $number;

    public function __construct(int $value)
    {
        $this->number = new Number\Number($value);
    }

    /**
     * {@inheritdoc}
     */
    public function value(): int
    {
        return $this->number->value();
    }

    public function equals(Number $number): bool
    {
        return $this->number->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->number->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->number->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->number->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->number->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->number->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return $this->number->round($precision, $mode);
    }

    public function floor(): Number
    {
        return $this->number->floor();
    }

    public function ceil(): Number
    {
        return $this->number->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->number->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->number->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->number->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->number->squareRoot();
    }

    public function factorial(): Factorial
    {
        return new Factorial($this->number->value());
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

    public function increment(): self
    {
        return new self($this->number->value() + 1);
    }

    public function decrement(): self
    {
        return new self($this->number->value() - 1);
    }

    public function toString(): string
    {
        return $this->number->toString();
    }
}
