<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Power implements Operation, Number
{
    private Number $number;
    private Number $power;

    private function __construct(Number $number, Number $power)
    {
        $this->number = $number;
        $this->power = $power;
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number, Number $power): self
    {
        return new self($number, $power);
    }

    public function result(): Number
    {
        return Number\Number::of(
            $this->number->value() ** $this->power->value(),
        );
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

    public function modulo(Number $modulus): Number
    {
        return Modulo::of($this, $modulus);
    }

    public function absolute(): Number
    {
        return Absolute::of($this);
    }

    public function power(Number $power): self
    {
        return new self($this, $power);
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
        if ($this->number instanceof SquareRoot && $this->square()) {
            return $this->number->number()->collapse();
        }

        return $this->result();
    }

    public function number(): Number
    {
        return $this->number;
    }

    public function square(): bool
    {
        return $this->power->equals(Value::two);
    }

    public function toString(): string
    {
        $number = $this->number instanceof Operation ?
            '('.$this->number->toString().')' : $this->number->toString();
        $power = $this->power instanceof Operation ?
            '('.$this->power->toString().')' : $this->power->toString();

        return $number.'^'.$power;
    }
}
