<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Number\Infinite,
    DefinitionSet\Set,
    DefinitionSet\Range,
};

/**
 * Base 2 logarithm
 * @psalm-immutable
 */
final class BinaryLogarithm implements Operation, Number
{
    private Number $number;

    public function __construct(Number $number)
    {
        self::definitionSet()->accept($number);

        $this->number = $number;
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
        return new Addition($this, $number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return new Subtraction($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return new Division($this, $number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return new Multiplication($this, $number, ...$numbers);
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
        return new Floor($this);
    }

    public function ceil(): Number
    {
        return new Ceil($this);
    }

    public function modulo(Number $modulus): Number
    {
        return new Modulo($this, $modulus);
    }

    public function absolute(): Number
    {
        return new Absolute($this);
    }

    public function power(Number $power): Number
    {
        return new Power($this, $power);
    }

    public function squareRoot(): Number
    {
        return new SquareRoot($this);
    }

    public function exponential(): Number
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): self
    {
        return new self($this);
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

    public function result(): Number
    {
        return Number\Number::wrap(
            \log($this->number->value(), 2),
        );
    }

    public static function definitionSet(): Set
    {
        return Range::exclusive(
            new Integer(0),
            Infinite::positive(),
        );
    }

    public function collapse(): Number
    {
        return $this->result();
    }

    public function toString(): string
    {
        return \sprintf('lb(%s)', $this->number->toString());
    }
}
