<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};

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
    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    #[\Override]
    public function toString(): string
    {
        return 'ℕ*';
    }
}
