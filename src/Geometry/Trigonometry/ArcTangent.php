<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
};

/**
 * Inverse of tangent, such as a===Tangent(ArcTangent(a))
 * @psalm-immutable
 */
final class ArcTangent
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
        return $this->arcTangent();
    }

    public function number(): Number
    {
        return $this->arcTangent()->number();
    }

    public function toString(): string
    {
        return \sprintf('tan⁻¹(%s)', $this->number->toString());
    }

    private function arcTangent(): Degree
    {
        $radians = Number::of(
            \atan(
                $this->number->value(),
            ),
        );

        return Radian::of($radians)->toDegree();
    }
}
