<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 * @internal
 */
final class RealNumbersExceptZero implements Implementation
{
    #[\Override]
    public function contains(Number $number): bool
    {
        return !$number->equals(Number::zero());
    }

    #[\Override]
    public function toString(): string
    {
        return 'ℝ*';
    }
}
