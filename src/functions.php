<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Real,
    Exception\LogicException,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-pure
 *
 * @return -1|0|1
 */
function asc(Number $a, Number $b): int
{
    if ($a->equals($b)) {
        return 0;
    }

    return $a->higherThan($b) ? 1 : -1;
}

/**
 * @psalm-pure
 *
 * @return -1|0|1
 */
function desc(Number $a, Number $b): int
{
    if ($a->equals($b)) {
        return 0;
    }

    return $b->higherThan($a) ? 1 : -1;
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function max(Number $first, Number ...$numbers): Number
{
    return Sequence::of($first, ...$numbers)
        ->sort(desc(...))
        ->first()
        ->match(
            static fn($max) => $max,
            static fn() => throw new LogicException('Unreachable'),
        );
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
function min(Number $first, Number ...$numbers): Number
{
    return Sequence::of($first, ...$numbers)
        ->sort(asc(...))
        ->first()
        ->match(
            static fn($min) => $min,
            static fn() => throw new LogicException('Unreachable'),
        );
}
