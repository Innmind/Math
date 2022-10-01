<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Modulo implements Operation, Number
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

    public function result(): Number
    {
        return $this->compute($this->number, $this->modulus);
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

    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
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

    public function modulo(Number $modulus): self
    {
        return new self($this, $modulus);
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

    public function collapse(): Number
    {
        return $this->compute(
            $this->number->collapse(),
            $this->modulus->collapse(),
        );
    }

    public function toString(): string
    {
        $number = $this->number instanceof Operation ?
            '('.$this->number->toString().')' : $this->number->toString();
        $modulus = $this->modulus instanceof Operation ?
            '('.$this->modulus->toString().')' : $this->modulus->toString();

        return $number.' % '.$modulus;
    }

    private function compute(Number $number, Number $modulus): Number
    {
        return Real::of(
            \fmod($number->value(), $modulus->value()),
        );
    }
}
