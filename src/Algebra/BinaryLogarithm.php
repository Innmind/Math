<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\DefinitionSet\Set;

/**
 * Base 2 logarithm
 * @psalm-immutable
 */
final class BinaryLogarithm implements Number
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
        return Addition::of($this, $number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return Subtraction::of($this, $number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return Multiplication::of($this, $number, ...$numbers);
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
    public function binaryLogarithm(): self
    {
        return new self($this);
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

    /**
     * @psalm-pure
     */
    public static function definitionSet(): Set
    {
        return Set::exclusiveRange(
            Value::zero,
            Value::infinite,
        );
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this->compute($this->number->collapse());
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('lb(%s)', $this->number->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }

    private function result(): Number
    {
        return $this->compute($this->number);
    }

    private function compute(Number $number): Number
    {
        return Real::of(
            \log($number->value(), 2),
        );
    }
}
