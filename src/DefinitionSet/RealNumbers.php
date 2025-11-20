<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 * @internal
 */
final class RealNumbers implements Implementation
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
        return 'ℝ';
    }
}
