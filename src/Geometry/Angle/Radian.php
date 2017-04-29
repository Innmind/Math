<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use Innmind\Math\Algebra\{
    NumberInterface,
    Number,
    Number\Pi
};

final class Radian
{
    private $number;
    private $degree;

    public function __construct(NumberInterface $number)
    {
        $modulus = (new Pi)->multiplyBy(new Number(2));
        $this->number = $number
            ->modulo($modulus)
            ->add($modulus)
            ->modulo($modulus);
    }

    public function toDegree(): Degree
    {
        return $this->degree ?? $this->degree = new Degree(
            new Number(
                rad2deg($this->number->value())
            )
        );
    }

    public function isRight(): bool
    {
        return $this->toDegree()->isRight();
    }

    public function isObtuse(): bool
    {
        return $this->toDegree()->isObtuse();
    }

    public function isAcuse(): bool
    {
        return $this->toDegree()->isAcuse();
    }

    public function isFlat(): bool
    {
        return $this->toDegree()->isFlat();
    }

    public function opposite(): self
    {
        return $this->toDegree()->opposite()->toRadian();
    }

    public function number(): NumberInterface
    {
        return $this->number;
    }

    public function __toString(): string
    {
        return $this->number->value().' rad';
    }
}
