<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 */
interface Set
{
    /**
     * ∈ or ∉
     */
    public function contains(Number $number): bool;

    /**
     * @throws OutOfDefinitionSet
     */
    public function accept(Number $number): void;
    public function union(self $set): self;
    public function intersect(self $set): self;
    public function toString(): string;
}
