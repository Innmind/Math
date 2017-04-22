<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};

/**
 * Inverse of cosine, such as a===Cosine(ArcCosine(a))
 */
final class ArcCosine
{
    private $arcCosine;

    public function __construct(Degree $degree)
    {
        $this->arcCosine = new Number(
            acos(
                $degree->toRadian()->number()->value()
            )
        );
    }

    public function __invoke(): NumberInterface
    {
        return $this->arcCosine;
    }
}
