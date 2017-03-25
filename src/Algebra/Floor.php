<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

final class Floor implements NumberInterface
{
    private $number;

    public function __construct(NumberInterface $number)
    {
        $this->number = $number;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return floor($this->number->value());
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
        return new self($this);
    }

    public function ceil(): NumberInterface
    {
        return new Ceil($this);
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
