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
 * sin(angle) = oppositeSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Sine
{
    private $sine;

    public function __construct(Degree $degree)
    {
        $this->sine = new Number(
            sin(
                $degree->toRadian()->number()->value()
            )
        );
    }

    public function __invoke(): NumberInterface
    {
        return $this->sine;
    }
}
