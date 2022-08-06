<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use function Innmind\Math\{
    cosine,
    arcCosine,
    add,
    max as maximum,
};
use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Geometry\Angle\Degree,
    Geometry\Segment,
    Exception\SegmentsCannotBeJoined,
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
        Segment $a,
        Degree $degree,
        Segment $b,
    ): Segment {
        $a = $a->length();
        $b = $b->length();

        $side = $a
            ->power(new Integer(2))
            ->add(
                $b->power(new Integer(2)),
            )
            ->subtract(
                (new Integer(2))
                    ->multiplyBy($a)
                    ->multiplyBy($b)
                    ->multiplyBy(cosine($degree)),
            )
            ->squareRoot();

        return new Segment($side);
    }

    /**
     * Return the angle between a and b sides
     */
    public static function angle(
        Segment $a,
        Segment $b,
        Segment $c,
    ): Degree {
        $a = $a->length();
        $b = $b->length();
        $c = $c->length();
        $longest = maximum($a, $b, $c);
        $opposites = Set::of($a, $b, $c)->remove($longest);
        $opposites = add(...$opposites->toList());

        if ($longest->higherThan($opposites) && !$longest->equals($opposites)) {
            throw new SegmentsCannotBeJoined;
        }

        $cosAB = $a
            ->power(new Integer(2))
            ->add($b->power(new Integer(2)))
            ->subtract($c->power(new Integer(2)))
            ->divideBy(
                (new Integer(2))
                    ->multiplyBy($a)
                    ->multiplyBy($b),
            );

        return arcCosine($cosAB)->toDegree();
    }

    public function toString(): string
    {
        return 'C²=A²+B²-2AB*cos(A,B)';
    }
}
