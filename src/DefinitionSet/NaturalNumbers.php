<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Algebra\Value,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 * @internal
 */
final class NaturalNumbers implements Implementation
{
    #[\Override]
    public function contains(Number $number): bool
    {
        if (Value::zero->higherThan($number)) {
            return false;
        }

        if ($number instanceof Integer) {
            return true;
        }

        return $number
            ->modulo(Value::one)
            ->equals(Value::zero);
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
        return 'ℕ';
    }
}
