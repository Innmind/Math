<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

final class RealNumbers implements Set
{
    public function contains(Number $number): bool
    {
        return true;
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
        return 'ℝ';
    }
}
