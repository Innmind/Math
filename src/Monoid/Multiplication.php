<?php
declare(strict_types = 1);

namespace Innmind\Math\Monoid;

use Innmind\Math\Algebra\Number;
use Innmind\Immutable\Monoid;

/**
 * @psalm-immutable
 * @implements Monoid<Number>
 */
enum Multiplication implements Monoid
{
    case monoid;

    #[\Override]
    public function identity(): Number
    {
        return Number::one();
    }

    #[\Override]
    public function combine(mixed $a, mixed $b): Number
    {
        return $a->multiplyBy($b);
    }
}
