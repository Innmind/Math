<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use function Innmind\Math\cosine;
use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Integer,
    Geometry\Angle\Degree
};

/**
 * Also known as the law of cosines
 *
 * It allows to calculate the length of a triangle's third side via the lengths
 * of the other sides and the opposite angle
 */
final class AlKashi
{
    public static function side(
        NumberInterface $a,
        Degree $degree,
        NumberInterface $b
    ): NumberInterface {
        return $a
            ->power(new Integer(2))
            ->add(
                $b->power(new Integer(2))
            )
            ->subtract(
                (new Integer(2))
                    ->multiplyBy($a)
                    ->multiplyBy($b)
                    ->multiplyBy(cosine($degree))
            )
            ->squareRoot();
    }

    public function __toString(): string
    {
        return 'C²=A²+B²-2AB*cos(A,B)';
    }
}
