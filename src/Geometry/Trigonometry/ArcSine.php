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
 * Inverse of sine, such as a===Sine(ArcSine(a))
 */
final class ArcSine
{
    private $arcSine;

    public function __construct(NumberInterface $number)
    {
        $radians = new Number(
            asin(
                $number->value()
            )
        );
        $this->arcSine = (new Radian($radians))->toDegree();
    }

    public function __invoke(): Degree
    {
        return $this->arcSine;
    }
}
