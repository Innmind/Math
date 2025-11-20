<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class RealNumbers implements Set
{
    #[\Override]
    public function contains(Number $number): bool
    {
        return true;
    }

    #[\Override]
    public function accept(Number $number): void
    {
        // it accepts everything
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
        return 'ℝ';
    }
}
