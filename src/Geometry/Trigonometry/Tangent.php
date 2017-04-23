<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};

/**
 * Given a right-angled rectangle
 *
 * tan(angle) = oppositeSide / adjacentSide
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Tangent
{
    private $tangent;

    public function __construct(Degree $degree)
    {
        $this->tangent = new Number(
            tan(
                $degree->toRadian()->number()->value()
            )
        );
    }

    public function __invoke(): NumberInterface
    {
        return $this->tangent;
    }
}
