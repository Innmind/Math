<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

interface Set
{
    /**
     * ∈ or ∉
     */
    public function contains(Number $number): bool;
    public function union(self $set): self;
    public function intersect(self $set): self;
    public function toString(): string;
}
