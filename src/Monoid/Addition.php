<?php
declare(strict_types = 1);

namespace Innmind\Math\Monoid;

use Innmind\Math\Algebra\{
    Number,
    Value,
};
use Innmind\Immutable\Monoid;

/**
 * @psalm-immutable
 * @implements Monoid<Number>
 */
final class Addition implements Monoid
{
    #[\Override]
    public function identity(): Number
    {
        return Value::zero;
    }

    #[\Override]
    public function combine(mixed $a, mixed $b): Number
    {
        return $a->add($b);
    }
}
