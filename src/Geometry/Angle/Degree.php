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
final class Degree
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
        $modulus = Number::of(360);

        return new self(
            $number
                ->modulo($modulus)
                ->add($modulus)
                ->modulo($modulus),
        );
    }

    #[\NoDiscard]
    public function toRadian(): Radian
    {
        return Radian::of(
            Number::of(
                \deg2rad($this->number->value()),
            ),
        );
    }

    #[\NoDiscard]
    public function right(): bool
    {
        return $this->number->equals(Number::of(90));
    }

    #[\NoDiscard]
    public function obtuse(): bool
    {
        return $this->number->higherThan(Number::of(90));
    }

    #[\NoDiscard]
    public function acuse(): bool
    {
        return Number::of(90)->higherThan($this->number);
    }

    #[\NoDiscard]
    public function flat(): bool
    {
        return $this->number->equals(Number::of(180));
    }

    #[\NoDiscard]
    public function opposite(): self
    {
        return self::of($this->number->add(Number::of(180)));
    }

    #[\NoDiscard]
    public function cosine(): Number
    {
        return $this
            ->toRadian()
            ->number()
            ->as($this->toString())
            ->apply(Trigonometry::cosine);
    }

    #[\NoDiscard]
    public function sine(): Number
    {
        return $this
            ->toRadian()
            ->number()
            ->as($this->toString())
            ->apply(Trigonometry::sine);
    }

    #[\NoDiscard]
    public function tangent(): Number
    {
        return $this
            ->toRadian()
            ->number()
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
        return $this->number->value().'°';
    }
}
