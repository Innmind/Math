<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
};

/**
 * Inverse of sine, such as a===Sine(ArcSine(a))
 * @psalm-immutable
 */
final class ArcSine
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
        return $this->arcSine();
    }

    public function number(): Number
    {
        return $this->arcSine()->number();
    }

    public function toString(): string
    {
        return \sprintf('sin⁻¹(%s)', $this->number->toString());
    }

    private function arcSine(): Degree
    {
        $radians = Number::of(
            \asin(
                $this->number->value(),
            ),
        );

        return Radian::of($radians)->toDegree();
    }
}
