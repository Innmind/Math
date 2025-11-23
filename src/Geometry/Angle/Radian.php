<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use Innmind\Math\{
    Algebra\Number,
    Geometry\Trigonometry,
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
            Number::pi()->multiplyBy(Number::two()),
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
            Number::of(
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

    public function cosine(): Number
    {
        return $this
            ->number
            ->as($this->toString())
            ->apply(Trigonometry::cosine);
    }

    public function sine(): Number
    {
        return $this
            ->number
            ->as($this->toString())
            ->apply(Trigonometry::sine);
    }

    public function tangent(): Number
    {
        return $this
            ->number
            ->as($this->toString())
            ->apply(Trigonometry::tangent);
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
