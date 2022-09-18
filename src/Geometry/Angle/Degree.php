<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Angle;

use Innmind\Math\Algebra\{
    Number,
    Integer,
};

/**
 * @psalm-immutable
 */
final class Degree
{
    private Number $number;

    private function __construct(Number $number)
    {
        $modulus = Number\Number::of(360);
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
            Number\Number::of(
                \deg2rad($this->number->value()),
            ),
        );
    }

    public function isRight(): bool
    {
        return $this->number->equals(Integer::of(90));
    }

    public function isObtuse(): bool
    {
        return $this->number->higherThan(Integer::of(90));
    }

    public function isAcuse(): bool
    {
        return Integer::of(90)->higherThan($this->number);
    }

    public function isFlat(): bool
    {
        return $this->number->equals(Integer::of(180));
    }

    public function opposite(): self
    {
        return new self($this->number->add(Integer::of(180)));
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
