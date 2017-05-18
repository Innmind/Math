<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};

/**
 * Inverse of sine, such as a===Sine(ArcSine(a))
 */
final class ArcSine
{
    private $arcSine;

    public function __construct(Degree $degree)
    {
        $this->arcSine = new Number(
            asin(
                $degree->toRadian()->number()->value()
            )
        );
    }

    public function __invoke(): NumberInterface
    {
        return $this->arcSine;
    }
}
