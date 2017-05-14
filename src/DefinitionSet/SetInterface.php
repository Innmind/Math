<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\NumberInterface;

interface SetInterface
{
    /**
     * ∈ or ∉
     */
    public function contains(NumberInterface $number): bool;
    public function union(self $set): self;
    public function intersect(self $set): self;
    public function __toString(): string;
}
