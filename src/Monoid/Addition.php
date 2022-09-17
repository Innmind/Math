<?php
declare(strict_types = 1);

namespace Innmind\Math\Monoid;

use Innmind\Math\Algebra\Number;
use Innmind\Immutable\Monoid;

/**
 * @psalm-immutable
 * @implements Monoid<Number>
 */
final class Addition implements Monoid
{
    public function identity(): Number
    {
        return Number\Number::of(0);
    }

    public function combine(mixed $a, mixed $b): Number
    {
        return $a->add($b);
    }
}
