<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use Innmind\Math\{
    Algebra\Number,
    Geometry\Segment
};

/**
 * The hypotenuse is referenced as C, adjacent sides are referenced as A and B
 */
final class Pythagora
{
    /**
     * Compute the hypotenuse for adjacent sides A and B
     */
    public static function hypotenuse(
        Segment $a,
        Segment $b
    ): Segment {
        $hypotenuse = $a
            ->length()
            ->power(new Number(2))
            ->add($b->length()->power(new Number(2)))
            ->squareRoot();

        return new Segment($hypotenuse);
    }

    /**
     * Compute a side A or B from the hypotenuse and one side
     */
    public static function adjacentSide(
        Segment $hypotenuse,
        Segment $adjacentSide
    ): Segment {
        $side = $hypotenuse
            ->length()
            ->power(new Number(2))
            ->subtract($adjacentSide->length()->power(new Number(2)))
            ->squareRoot();

        return new Segment($side);
    }

    public function __toString(): string
    {
        return 'C²=A²+B²';
    }
}
