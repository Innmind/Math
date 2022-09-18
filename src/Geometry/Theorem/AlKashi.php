<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use function Innmind\Math\{
    cosine,
    arcCosine,
    max as maximum,
};
use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Geometry\Angle\Degree,
    Geometry\Segment,
    Exception\SegmentsCannotBeJoined,
};

/**
 * Also known as the law of cosines
 *
 * It allows to calculate the length of a triangle's third side via the lengths
 * of the other sides and the opposite angle
 * @psalm-immutable
 */
final class AlKashi
{
    /**
     * @psalm-pure
     */
    public static function side(
        Segment $a,
        Degree $degree,
        Segment $b,
    ): Segment {
        $a = $a->length();
        $b = $b->length();

        $side = $a
            ->power(Integer::of(2))
            ->add(
                $b->power(Integer::of(2)),
            )
            ->subtract(
                Integer::of(2)
                    ->multiplyBy($a)
                    ->multiplyBy($b)
                    ->multiplyBy(cosine($degree)),
            )
            ->squareRoot();

        return Segment::of($side);
    }

    /**
     * Return the angle between a and b sides
     * @psalm-pure
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
        $opposites = match ($longest) {
            $a => $b->add($c),
            $b => $a->add($c),
            $c => $a->add($b),
        };

        if ($longest->higherThan($opposites) && !$longest->equals($opposites)) {
            throw new SegmentsCannotBeJoined;
        }

        $cosAB = $a
            ->power(Integer::of(2))
            ->add($b->power(Integer::of(2)))
            ->subtract($c->power(Integer::of(2)))
            ->divideBy(
                Integer::of(2)
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
