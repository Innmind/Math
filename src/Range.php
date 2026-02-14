<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Immutable\Sequence;

final class Range
{
    /**
     * @psalm-pure
     *
     * @param int<1, max> $max
     *
     * @return Sequence<int>
     */
    #[\NoDiscard]
    public static function until(int $max): Sequence
    {
        return self::of(0, $max - 1);
    }

    /**
     * @psalm-pure
     *
     * @return Sequence<int>
     */
    #[\NoDiscard]
    public static function of(int $min, int $max): Sequence
    {
        return Sequence::of(...\range($min, $max));
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $min
     * @param int<1, max> $max
     *
     * @return Sequence<int<1, max>>
     */
    #[\NoDiscard]
    public static function ofPositive(int $min, int $max): Sequence
    {
        /** @var Sequence<int<1, max>> */
        return Sequence::of(...\range($min, $max));
    }
}
