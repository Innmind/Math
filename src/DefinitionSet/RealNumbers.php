<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class RealNumbers implements Set
{
    public function contains(Number $number): bool
    {
        return true;
    }

    public function accept(Number $number): void
    {
        // it accepts everything
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
        return 'ℝ';
    }
}
