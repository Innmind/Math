<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};

/**
 * Inverse of tangent, such as a===Tangent(ArcTangent(a))
 */
final class ArcTangent
{
    private $arcTangent;

    public function __construct(Degree $degree)
    {
        $this->arcTangent = new Number(
            atan(
                $degree->toRadian()->number()->value()
            )
        );
    }

    public function __invoke(): NumberInterface
    {
        return $this->arcTangent;
    }
}
