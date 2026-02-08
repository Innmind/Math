<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 * @internal
 */
final class NaturalNumbersExceptZero implements Implementation
{
    #[\Override]
    public function contains(Number $number): bool
    {
        if (Number::one()->higherThan($number)) {
            return false;
        }

        return $number
            ->modulo(Number::one())
            ->equals(Number::zero());
    }

    #[\Override]
    public function toString(): string
    {
        return 'ℕ*';
    }
}
