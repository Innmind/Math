<?php
declare(strict_types = 1);

namespace Innmind\Math;

use Innmind\Math\Algebra\Number;

/**
 * @no-named-arguments
 * @psalm-pure
 *
 * @return list<Number>
 */
function numerize(int|float|Number ...$numbers): array
{
    return \array_map(
        static fn($number): Number => $number instanceof Number ? $number : Number::of($number),
        $numbers,
    );
}
