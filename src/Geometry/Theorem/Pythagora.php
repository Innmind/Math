<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Theorem;

use Innmind\Math\Algebra\{
    NumberInterface,
    Number
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
        NumberInterface $a,
        NumberInterface $b
    ): NumberInterface {
        return $a
            ->power(new Number(2))
            ->add($b->power(new Number(2)))
            ->squareRoot();
    }

    /**
     * Compute a side A or B from the hypotenuse and one side
     */
    public static function adjacentSide(
        NumberInterface $hypotenuse,
        NumberInterface $adjacentSide
    ): NumberInterface {
        return $hypotenuse
            ->power(new Number(2))
            ->subtract($adjacentSide->power(new Number(2)))
            ->squareRoot();
    }

    public function __toString(): string
    {
        return 'C²=A²+B²';
    }
}
