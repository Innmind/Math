<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use Innmind\Math\{
    Algebra\Value,
    Geometry\Segment,
};

/**
 * The hypotenuse is referenced as C, adjacent sides are referenced as A and B
 * @psalm-immutable
 */
final class Pythagora
{
    /**
     * Compute the hypotenuse for adjacent sides A and B
     * @psalm-pure
     */
    public static function hypotenuse(
        Segment $a,
        Segment $b,
    ): Segment {
        $hypotenuse = $a
            ->length()
            ->power(Value::two)
            ->add($b->length()->power(Value::two))
            ->squareRoot();

        return Segment::of($hypotenuse);
    }

    /**
     * Compute a side A or B from the hypotenuse and one side
     * @psalm-pure
     */
    public static function adjacentSide(
        Segment $hypotenuse,
        Segment $adjacentSide,
    ): Segment {
        $side = $hypotenuse
            ->length()
            ->power(Value::two)
            ->subtract($adjacentSide->length()->power(Value::two))
            ->squareRoot();

        return Segment::of($side);
    }

    public function toString(): string
    {
        return 'C²=A²+B²';
    }
}
