<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 * @internal
 */
interface Implementation
{
    /**
     * ∈ or ∉
     */
    public function contains(Number $number): bool;

    /**
     * @throws OutOfDefinitionSet
     */
    public function accept(Number $number): void;
    public function toString(): string;
}
