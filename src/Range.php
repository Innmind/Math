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
    public static function of(Integer $min, Integer $max): Sequence
    {
        return Sequence::lazy(static function() use ($min, $max) {
            while ($max->higherThan($min) || $max->equals($min)) {
                yield $min;
                $min = $min->increment();
            }
        });
    }

    /**
     * @psalm-pure
     *
     * @return Sequence<Integer\Positive>
     */
    public static function ofPositive(Integer\Positive $min, Integer\Positive $max): Sequence
    {
        return Sequence::lazy(static function() use ($min, $max) {
            while ($max->higherThan($min) || $max->equals($min)) {
                yield $min;
                $min = $min->increment();
            }
        });
    }
}
