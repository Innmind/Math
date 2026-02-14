<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use function Innmind\Math\max as maximum;
use Innmind\Math\{
    Algebra\Number,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Geometry\Segment,
    Geometry\Trigonometry,
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
    #[\NoDiscard]
    public static function side(
        Segment $a,
        Degree $degree,
        Segment $b,
    ): Segment {
        $a = $a->length();
        $b = $b->length();

        $side = $a
            ->power(Number::two())
            ->add(
                $b->power(Number::two()),
            )
            ->subtract(
                Number::two()
                    ->multiplyBy($a)
                    ->multiplyBy($b)
                    ->multiplyBy($degree->cosine()),
            )
            ->squareRoot();

        return Segment::of($side);
    }

    /**
     * Return the angle between a and b sides
     * @psalm-pure
     */
    #[\NoDiscard]
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
            ->power(Number::two())
            ->add($b->power(Number::two()))
            ->subtract($c->power(Number::two()))
            ->divideBy(
                Number::two()
                    ->multiplyBy($a)
                    ->multiplyBy($b),
            );

        return Radian::of($cosAB->apply(Trigonometry::arcCosine))->toDegree();
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return 'C²=A²+B²-2AB*cos(A,B)';
    }
}
