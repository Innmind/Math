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
 */
final class NaturalNumbersExceptZero implements Set
{
    public function contains(Number $number): bool
    {
        if (Value::one->higherThan($number)) {
            return false;
        }

        if ($number instanceof Integer) {
            return true;
        }

        return $number
            ->modulo(Value::one)
            ->equals(Value::zero);
    }

    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    public function union(Set $set): Set
    {
        return Union::of($this, $set);
    }

    public function intersect(Set $set): Set
    {
        return Intersection::of($this, $set);
    }

    public function toString(): string
    {
        return 'ℕ*';
    }
}
