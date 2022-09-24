<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Real,
};

/**
 * @no-named-arguments
 * @psalm-pure
 *
 * @return list<Number>
 */
function numerize(int|float|Number ...$numbers): array
{
    return \array_map(
        static fn($number): Number => $number instanceof Number ? $number : Real::of($number),
        $numbers,
    );
}
