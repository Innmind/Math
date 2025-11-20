<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Value,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 */
final class RealNumbersExceptZero implements Set
{
    #[\Override]
    public function contains(Number $number): bool
    {
        return !$number->equals(Value::zero);
    }

    #[\Override]
    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    #[\Override]
    public function union(Set $set): Set
    {
        return Union::of($this, $set);
    }

    #[\Override]
    public function intersect(Set $set): Set
    {
        return Intersection::of($this, $set);
    }

    #[\Override]
    public function toString(): string
    {
        return 'ℝ*';
    }
}
