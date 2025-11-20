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
    public function toString(): string
    {
        return 'ℝ';
    }
}
