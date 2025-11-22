<?php
declare(strict_types = 1);

namespace Innmind\Math\Monoid;

use Innmind\Math\Algebra\Number;
use Innmind\Immutable\Monoid;

/**
 * @psalm-immutable
 * @implements Monoid<Number>
 */
enum Addition implements Monoid
{
    case monoid;

    #[\Override]
    public function identity(): Number
    {
        return Number::zero();
    }

    #[\Override]
    public function combine(mixed $a, mixed $b): Number
    {
        return $a->add($b);
    }
}
