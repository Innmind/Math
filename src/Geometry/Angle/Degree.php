<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use Innmind\Math\Algebra\{
    NumberInterface,
    Number
};

final class Degree
{
    private $number;

    public function __construct(NumberInterface $number)
    {
        $modulus = new Number(360);
        $this->number = $number
            ->modulo($modulus)
            ->add($modulus)
            ->modulo($modulus);
    }

    public function isRight(): bool
    {
        return $this->number->equals(new Number(90));
    }

    public function isObtuse(): bool
    {
        return $this->number->higherThan(new Number(90));
    }

    public function isAcuse(): bool
    {
        return (new Number(90))->higherThan($this->number);
    }

    public function isFlat(): bool
    {
        return $this->number->equals(new Number(180));
    }

    public function opposite(): self
    {
        return new self($this->number->add(new Number(180)));
    }

    public function __toString(): string
    {
        return $this->number->value().'°';
    }
}
