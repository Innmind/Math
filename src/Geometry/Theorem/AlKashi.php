<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use function Innmind\Math\{
    cosine,
    arcCosine,
    add
};
use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Integer,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Exception\OpenFigureException
};
use Innmind\Immutable\Set;

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

    /**
     * Return the angle between a and b sides
     */
    public static function angle(
        NumberInterface $a,
        NumberInterface $b,
        NumberInterface $c
    ): Degree {
        $longest = max($a, $b, $c);
        $opposites = (new Set(NumberInterface::class))
            ->add($a)
            ->add($b)
            ->add($c)
            ->remove($longest);
        $opposites = add(...$opposites);

        if ($longest->higherThan($opposites) && !$longest->equals($opposites)) {
            throw new OpenFigureException;
        }

        $cosAB = $a
            ->power(new Integer(2))
            ->add($b->power(new Integer(2)))
            ->subtract($c->power(new Integer(2)))
            ->divideBy(
                (new Integer(2))
                    ->multiplyBy($a)
                    ->multiplyBy($b)
            );

        return (new Radian(arcCosine($cosAB)))->toDegree();
    }

    public function __toString(): string
    {
        return 'C²=A²+B²-2AB*cos(A,B)';
    }
}
