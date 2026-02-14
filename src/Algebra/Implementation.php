<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
interface Implementation
{
    public function value(): int|float;
    public function equals(self $number): bool;
    public function toString(): string;
    public function format(): string;
    public function optimize(): self;
}
