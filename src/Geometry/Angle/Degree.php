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

    public function toRadian(): Radian
    {
        return Radian::of(
            Number::of(
                \deg2rad($this->number->value()),
            ),
        );
    }

    public function isRight(): bool
    {
        return $this->number->equals(Number::of(90));
    }

    public function isObtuse(): bool
    {
        return $this->number->higherThan(Number::of(90));
    }

    public function isAcuse(): bool
    {
        return Number::of(90)->higherThan($this->number);
    }

    public function isFlat(): bool
    {
        return $this->number->equals(Number::of(180));
    }

    public function opposite(): self
    {
        return self::of($this->number->add(Number::of(180)));
    }

    public function cosine(): Number
    {
        return $this
            ->toRadian()
            ->number()
            ->as($this->toString())
            ->apply(Trigonometry::cosine);
    }

    public function sine(): Number
    {
        return $this
            ->toRadian()
            ->number()
            ->as($this->toString())
            ->apply(Trigonometry::sine);
    }

    public function tangent(): Number
    {
        return $this
            ->toRadian()
            ->number()
            ->as($this->toString())
            ->apply(Trigonometry::tangent);
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
