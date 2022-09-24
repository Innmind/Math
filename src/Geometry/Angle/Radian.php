<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use function Innmind\Math\multiply;
use Innmind\Math\Algebra\{
    Number,
    Value,
    Real,
};

/**
 * @psalm-immutable
 */
final class Radian
{
    private Number $number;

    private function __construct(Number $number)
    {
        $this->number = $number->modulo(
            multiply(2, Value::pi),
        );
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number): self
    {
        return new self($number);
    }

    public function toDegree(): Degree
    {
        return Degree::of(
            Real::of(
                \rad2deg($this->number->value()),
            ),
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
