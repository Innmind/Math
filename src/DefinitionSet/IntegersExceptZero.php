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
final class IntegersExceptZero implements Implementation
{
    #[\Override]
    public function contains(Number $number): bool
    {
        if ($number->equals(Number::zero())) {
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
        return 'ℤ*';
    }
}
