<?php
declare(strict_types = 1);

namespace Innmind\Math\Monoid;

use Innmind\Math\Algebra\Number;
use Innmind\Immutable\Monoid;

/**
 * @psalm-immutable
 * @implements Monoid<Number>
 */
enum Algebra implements Monoid
{
    case addition;
    case multiplication;

    #[\Override]
    public function identity(): Number
    {
        return match ($this) {
            self::addition => Number::zero(),
            self::multiplication => Number::one(),
        };
    }

    #[\Override]
    public function combine(mixed $a, mixed $b): Number
    {
        return match ($this) {
            self::addition => $a->add($b),
            self::multiplication => $a->multiplyBy($b),
        };
    }
}
