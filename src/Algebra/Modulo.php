<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Modulo implements Number
{
    private Number $number;
    private Number $modulus;

    private function __construct(Number $number, Number $modulus)
    {
        $this->number = $number;
        $this->modulus = $modulus;
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number, Number $modulus): self
    {
        return new self($number, $modulus);
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
    public function modulo(Number $modulus): self
    {
        return new self($this, $modulus);
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
        return $this->compute(
            $this->number->collapse(),
            $this->modulus->collapse(),
        );
    }

    #[\Override]
    public function toString(): string
    {
        $number = $this->number->format();
        $modulus = $this->modulus->format();

        return $number.' % '.$modulus;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function result(): Number
    {
        return $this->compute($this->number, $this->modulus);
    }

    private function compute(Number $number, Number $modulus): Number
    {
        return Real::of(
            \fmod($number->value(), $modulus->value()),
        );
    }
}
