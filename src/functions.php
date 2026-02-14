<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\{
    Algebra\Number,
    Exception\LogicException,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-pure
 *
 * @return -1|0|1
 */
#[\NoDiscard]
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
#[\NoDiscard]
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
#[\NoDiscard]
function max(Number $first, Number ...$numbers): Number
{
    return Sequence::of($first, ...$numbers)
        ->sort(desc(...))
        ->first()
        ->attempt(static fn() => new LogicException('Unreachable'))
        ->unwrap();
}

/**
 * @no-named-arguments
 * @psalm-pure
 */
#[\NoDiscard]
function min(Number $first, Number ...$numbers): Number
{
    return Sequence::of($first, ...$numbers)
        ->sort(asc(...))
        ->first()
        ->attempt(static fn() => new LogicException('Unreachable'))
        ->unwrap();
}
