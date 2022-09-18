<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Number\Infinite,
    DefinitionSet\Set,
    DefinitionSet\Range,
};

/**
 * Base 10 logarithm
 * @psalm-immutable
 */
final class CommonLogarithm implements Operation, Number
{
    private Number $number;

    private function __construct(Number $number)
    {
        self::definitionSet()->accept($number);

        $this->number = $number;
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number): self
    {
        return new self($number);
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

    public function commonLogarithm(): self
    {
        return new self($this);
    }

    public function signum(): Number
    {
        return Signum::of($this);
    }

    public function result(): Number
    {
        return $this->compute($this->number);
    }

    public static function definitionSet(): Set
    {
        return Range::exclusive(
            Integer::of(0),
            Infinite::positive(),
        );
    }

    public function collapse(): Number
    {
        return $this->compute($this->number->collapse());
    }

    public function toString(): string
    {
        return \sprintf('lg(%s)', $this->number->toString());
    }

    private function compute(Number $number): Number
    {
        return Number\Number::of(
            \log10($number->value()),
        );
    }
}
