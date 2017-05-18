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
 * Inverse of cosine, such as a===Cosine(ArcCosine(a))
 */
final class ArcCosine
{
    private $arcCosine;

    public function __construct(NumberInterface $number)
    {
        $radians = new Number(
            acos(
                $number->value()
            )
        );
        $this->arcCosine = (new Radian($radians))->toDegree();
    }

    public function __invoke(): Degree
    {
        return $this->arcCosine;
    }
}
