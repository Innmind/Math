<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

final class Floor implements NumberInterface
{
    private $number;
    private $value;

    public function __construct(NumberInterface $number)
    {
        $this->number = $number;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value ?? $this->value = floor($this->number->value());
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(NumberInterface ...$numbers): NumberInterface
    {
        return new Addition($this, ...$numbers);
    }

    public function subtract(NumberInterface ...$numbers): NumberInterface
    {
        return new Subtraction($this, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new Division($this, $number);
    }

    public function multiplyBy(NumberInterface ...$numbers): NumberInterface
    {
        return new Multiplication($this, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return new Round($this, $precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return new self($this);
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

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
