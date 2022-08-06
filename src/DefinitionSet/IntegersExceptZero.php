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
        if ($number->equals(new Integer(0))) {
            return false;
        }

        if ($number instanceof Integer) {
            return true;
        }

        return $number
            ->modulo(new Integer(1))
            ->equals(new Integer(0));
    }

    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    public function union(Set $set): Set
    {
        return new Union($this, $set);
    }

    public function intersect(Set $set): Set
    {
        return new Intersection($this, $set);
    }

    public function toString(): string
    {
        return 'ℤ*';
    }
}
