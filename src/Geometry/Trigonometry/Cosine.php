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
 * cos(angle) = adjacentSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Cosine
{
    private $cosine;

    public function __construct(Degree $degree)
    {
        $this->cosine = new Number(
            cos(
                $degree->toRadian()->number()->value()
            )
        );
    }

    public function __invoke(): NumberInterface
    {
        return $this->cosine;
    }
}
