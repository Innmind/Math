<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    NumberInterface,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo
};

final class Pi implements NumberInterface
{
    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return pi();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(NumberInterface $number): NumberInterface
    {
        return new Addition($this, $number);
    }

    public function subtract(NumberInterface $number): NumberInterface
    {
        return new Subtraction($this, $number);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new Division($this, $number);
    }

    public function multiplyBy(NumberInterface $number): NumberInterface
    {
        return new Multiplication($this, $number);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return new Round($this, $precision, $mode);
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

    public function __toString(): string
    {
        return 'π';
    }
}
