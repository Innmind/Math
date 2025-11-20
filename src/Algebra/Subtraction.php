<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Subtraction implements Number
{
    /**
     * @param Sequence<Number> $values
     */
    private function __construct(
        private Number $first,
        private Sequence $values,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $first, Number $second): self
    {
        return new self($first, Sequence::of($first, $second));
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->difference()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->difference()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->difference()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number): Number
    {
        return Addition::of($this, $number);
    }

    #[\Override]
    public function subtract(Number $number): self
    {
        return new self(
            $this->first,
            ($this->values)($number),
        );
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

    public function difference(): Number
    {
        return $this->compute($this->first, $this->values);
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this->compute(
            $this->first->collapse(),
            $this->values->map(static fn($value) => $value->collapse()),
        );
    }

    #[\Override]
    public function toString(): string
    {
        $values = $this->values->map(
            static fn($number) => $number->format(),
        );

        return Str::of(' - ')->join($values)->toString();
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    /**
     * @param Sequence<Number> $values
     */
    private function compute(Number $first, Sequence $values): Number
    {
        $value = $values
            ->drop(1)
            ->reduce(
                $first->value(),
                static fn(int|float $carry, $number): int|float => $carry - $number->value(),
            );

        return Real::of($value);
    }
}
