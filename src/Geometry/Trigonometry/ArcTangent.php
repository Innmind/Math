<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\NumberInterface,
    Algebra\Number
};

/**
 * Inverse of tangent, such as a===Tangent(ArcTangent(a))
 */
final class ArcTangent
{
    private $arcTangent;

    public function __construct(NumberInterface $number)
    {
        $radians = new Number(
            atan(
                $number->value()
            )
        );
        $this->arcTangent = (new Radian($radians))->toDegree();
    }

    public function __invoke(): Degree
    {
        return $this->arcTangent;
    }
}
