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
 * @internal
 */
final class RealNumbersExceptZero implements Implementation
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
    public function union(Implementation $set): Implementation
    {
        return Union::of($this, $set);
    }

    #[\Override]
    public function intersect(Implementation $set): Implementation
    {
        return Intersection::of($this, $set);
    }

    #[\Override]
    public function toString(): string
    {
        return 'ℝ*';
    }
}
