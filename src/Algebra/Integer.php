<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Integer implements Number
{
    private Number $number;

    private function __construct(int $value)
    {
        $this->number = Number\Number::int($value);
    }

    /**
     * @psalm-pure
     */
    public static function of(int $value): self
    {
        return new self($value);
    }

    public function value(): int
    {
        /** @var int */
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

    public function roundUp(int $precision = 0): Number
    {
        return $this->number->roundUp($precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return $this->number->roundDown($precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return $this->number->roundEven($precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return $this->number->roundOdd($precision);
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
        /** @psalm-suppress PossiblyInvalidArgument */
        return Factorial::of($this->number->value());
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
        /** @psalm-suppress PossiblyInvalidArgument */
        return new self($this->number->value() + 1);
    }

    public function decrement(): self
    {
        /** @psalm-suppress PossiblyInvalidArgument */
        return new self($this->number->value() - 1);
    }

    public function collapse(): Number
    {
        return $this;
    }

    public function toString(): string
    {
        return $this->number->toString();
    }
}
