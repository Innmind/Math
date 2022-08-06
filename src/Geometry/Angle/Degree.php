<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use Innmind\Math\Algebra\{
    Number,
    Integer,
};

final class Degree
{
    private Number $number;

    public function __construct(Number $number)
    {
        $modulus = new Number\Number(360);
        $this->number = $number
            ->modulo($modulus)
            ->add($modulus)
            ->modulo($modulus);
    }

    public function toRadian(): Radian
    {
        return new Radian(
            new Number\Number(
                \deg2rad($this->number->value()),
            ),
        );
    }

    public function isRight(): bool
    {
        return $this->number->equals(new Integer(90));
    }

    public function isObtuse(): bool
    {
        return $this->number->higherThan(new Integer(90));
    }

    public function isAcuse(): bool
    {
        return (new Integer(90))->higherThan($this->number);
    }

    public function isFlat(): bool
    {
        return $this->number->equals(new Integer(180));
    }

    public function opposite(): self
    {
        return new self($this->number->add(new Integer(180)));
    }

    public function number(): Number
    {
        return $this->number;
    }

    public function toString(): string
    {
        return $this->number->value().'°';
    }
}
