<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Number\Infinite,
    DefinitionSet\Set,
    DefinitionSet\Range,
    Exception\OutOfDefinitionSet
};

/**
 * Base 2 logarithm
 */
final class BinaryLogarithm implements Operation, Number
{
    private static Set $definitionSet;

    private Number $number;
    private ?Number $result = null;

    public function __construct(Number $number)
    {
        if (!self::definitionSet()->contains($number)) {
            throw new OutOfDefinitionSet(self::definitionSet(), $number);
        }

        $this->number = $number;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
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

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return new Round($this, $precision, $mode);
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

    public function binaryLogarithm(): Number
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
        return $this->result ??= Number\Number::wrap(
            log($this->number->value(), 2)
        );
    }

    public static function definitionSet(): Set
    {
        return self::$definitionSet ??= Range::exclusive(
            new Integer(0),
            Infinite::positive()
        );
    }

    public function toString(): string
    {
        return sprintf('lb(%s)', $this->number->toString());
    }
}
