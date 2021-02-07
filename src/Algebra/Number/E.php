<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    Number as NumberInterface,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
};

/**
 * 1/0! + 1/1! + 1/2! + 1/3! + ... + 1/n!
 */
final class E implements NumberInterface
{
    public function value()
    {
        return \M_E;
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return new Addition($this, $number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return new Subtraction($this, $number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new Division($this, $number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return new Multiplication($this, $number, ...$numbers);
    }

    public function roundUp(int $precision = 0): NumberInterface
    {
        return Round::up($this, $precision);
    }

    public function roundDown(int $precision = 0): NumberInterface
    {
        return Round::down($this, $precision);
    }

    public function roundEven(int $precision = 0): NumberInterface
    {
        return Round::even($this, $precision);
    }

    public function roundOdd(int $precision = 0): NumberInterface
    {
        return Round::odd($this, $precision);
    }

    public function floor(): NumberInterface
    {
        return new Floor($this);
    }

    public function ceil(): NumberInterface
    {
        return new Ceil($this);
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return new Modulo($this, $modulus);
    }

    public function absolute(): NumberInterface
    {
        return new Absolute($this);
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return new Power($this, $power);
    }

    public function squareRoot(): NumberInterface
    {
        return new SquareRoot($this);
    }

    public function exponential(): NumberInterface
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): NumberInterface
    {
        return new BinaryLogarithm($this);
    }

    public function naturalLogarithm(): NumberInterface
    {
        return new NaturalLogarithm($this);
    }

    public function commonLogarithm(): NumberInterface
    {
        return new CommonLogarithm($this);
    }

    public function signum(): NumberInterface
    {
        return new Signum($this);
    }

    public function toString(): string
    {
        return 'e';
    }
}
