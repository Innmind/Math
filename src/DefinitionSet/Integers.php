<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 * @internal
 */
final class Integers implements Implementation
{
    #[\Override]
    public function contains(Number $number): bool
    {
        return $number
            ->modulo(Number::one())
            ->equals(Number::zero());
    }

    #[\Override]
    public function toString(): string
    {
        return 'ℤ';
    }
}
