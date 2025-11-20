<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Power implements Number
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
    public function modulo(Number $modulus): Number
    {
        return Modulo::of($this, $modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return Absolute::of($this);
    }

    #[\Override]
    public function power(Number $power): self
    {
        return new self($this, $power);
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

    #[\Override]
    public function toString(): string
    {
        $number = $this->number->format();
        $power = $this->power->format();

        return $number.'^'.$power;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function result(): Number
    {
        return Real::of(
            $this->number->value() ** $this->power->value(),
        );
    }
}
