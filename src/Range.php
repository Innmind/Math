<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\Algebra\Integer;
use Innmind\Immutable\Sequence;

final class Range
{
    /**
     * @psalm-pure
     *
     * @return Sequence<Integer>
     */
    public static function until(Integer\Positive $max): Sequence
    {
        return self::of(Integer::of(0), $max->decrement());
    }

    /**
     * @psalm-pure
     *
     * @return Sequence<Integer>
     */
    public static function of(Integer $min, Integer $max): Sequence
    {
        return Sequence::of(...\range($min->value(), $max->value()))
            ->map(Integer::of(...));
    }

    /**
     * @psalm-pure
     *
     * @return Sequence<Integer\Positive>
     */
    public static function ofPositive(Integer\Positive $min, Integer\Positive $max): Sequence
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        return Sequence::of(...\range($min->value(), $max->value()))
            ->map(Integer::positive(...));
    }
}
