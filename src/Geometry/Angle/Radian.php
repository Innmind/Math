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
    #[\NoDiscard]
    public static function of(Number $number): self
    {
        return new self($number->modulo(
            Number::pi()->multiplyBy(Number::two()),
        ));
    }

    #[\NoDiscard]
    public function toDegree(): Degree
    {
        return Degree::of(
            Number::of(
                \rad2deg($this->number->value()),
            ),
        );
    }

    #[\NoDiscard]
    public function right(): bool
    {
        return $this->toDegree()->right();
    }

    #[\NoDiscard]
    public function obtuse(): bool
    {
        return $this->toDegree()->obtuse();
    }

    #[\NoDiscard]
    public function acuse(): bool
    {
        return $this->toDegree()->acuse();
    }

    #[\NoDiscard]
    public function flat(): bool
    {
        return $this->toDegree()->flat();
    }

    #[\NoDiscard]
    public function opposite(): self
    {
        return $this->toDegree()->opposite()->toRadian();
    }

    #[\NoDiscard]
    public function cosine(): Number
    {
        return $this
            ->number
            ->as($this->toString())
            ->apply(Trigonometry::cosine);
    }

    #[\NoDiscard]
    public function sine(): Number
    {
        return $this
            ->number
            ->as($this->toString())
            ->apply(Trigonometry::sine);
    }

    #[\NoDiscard]
    public function tangent(): Number
    {
        return $this
            ->number
            ->as($this->toString())
            ->apply(Trigonometry::tangent);
    }

    #[\NoDiscard]
    public function number(): Number
    {
        return $this->number;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return $this->number->value().' rad';
    }
}
