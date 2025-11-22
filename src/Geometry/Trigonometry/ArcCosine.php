<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
};

/**
 * Inverse of cosine, such as a===Cosine(ArcCosine(a))
 * @psalm-immutable
 */
final class ArcCosine
{
    private Number $number;

    private function __construct(Number $number)
    {
        $this->number = $number;
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
        return $this->arcCosine();
    }

    public function number(): Number
    {
        return $this->arcCosine()->number();
    }

    public function toString(): string
    {
        return \sprintf('cos⁻¹(%s)', $this->number->toString());
    }

    private function arcCosine(): Degree
    {
        $radians = Number::of(
            \acos(
                $this->number->value(),
            ),
        );

        return Radian::of($radians)->toDegree();
    }
}
