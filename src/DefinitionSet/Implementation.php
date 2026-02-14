<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

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
    public function toString(): string;
}
