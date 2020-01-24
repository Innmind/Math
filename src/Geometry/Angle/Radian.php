<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use function Innmind\Math\multiply;
use Innmind\Math\Algebra\{
    Number,
    Number\Pi
};

final class Radian
{
    private $number;
    private $degree;

    public function __construct(Number $number)
    {
        $this->number = $number->modulo(
            multiply(2, new Pi)
        );
    }

    public function toDegree(): Degree
    {
        return $this->degree ?? $this->degree = new Degree(
            new Number\Number(
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

    public function number(): Number
    {
        return $this->number;
    }

    public function toString(): string
    {
        return $this->number->value().' rad';
    }
}
