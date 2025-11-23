<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Degree
{
    private Number $number;

    private function __construct(Number $number)
    {
        $modulus = Number::of(360);
        $this->number = $number
            ->modulo($modulus)
            ->add($modulus)
            ->modulo($modulus);
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number): self
    {
        return new self($number);
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
        return new self($this->number->add(Number::of(180)));
    }

    public function cosine(): Number
    {
        return $this->toRadian()->cosine();
    }

    public function sine(): Number
    {
        return $this->toRadian()->sine();
    }

    public function tangent(): Number
    {
        return $this->toRadian()->tangent();
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
