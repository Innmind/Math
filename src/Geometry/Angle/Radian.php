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
    private function __construct(private Number $number)
    {
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number): self
    {
        return new self($number->modulo(
            Number::pi()->multiplyBy(Number::two()),
        ));
    }

    public function toDegree(): Degree
    {
        return Degree::of(
            Number::of(
                \rad2deg($this->number->value()),
            ),
        );
    }

    public function right(): bool
    {
        return $this->toDegree()->right();
    }

    public function obtuse(): bool
    {
        return $this->toDegree()->obtuse();
    }

    public function acuse(): bool
    {
        return $this->toDegree()->acuse();
    }

    public function flat(): bool
    {
        return $this->toDegree()->flat();
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
