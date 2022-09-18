<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 */
final class IntegersExceptZero implements Set
{
    public function contains(Number $number): bool
    {
        if ($number->equals(Integer::of(0))) {
            return false;
        }

        if ($number instanceof Integer) {
            return true;
        }

        return $number
            ->modulo(Integer::of(1))
            ->equals(Integer::of(0));
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
        return 'ℤ*';
    }
}
