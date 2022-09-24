<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Real,
};
use Innmind\Immutable\Sequence;

/**
 * @no-named-arguments
 * @psalm-pure
 */
function max(Number $first, Number ...$numbers): Number
{
    return Sequence::of($first, ...$numbers)
        ->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $b->higherThan($a) ? 1 : -1;
        })
        ->first()
        ->match(
            static fn($max) => $max,
            static fn() => throw new \LogicException('Unreachable'),
        );
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function min(Number $first, Number ...$numbers): Number
{
    return Sequence::of($first, ...$numbers)
        ->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $a->higherThan($b) ? 1 : -1;
        })
        ->first()
        ->match(
            static fn($min) => $min,
            static fn() => throw new \LogicException('Unreachable'),
        );
}
