<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
interface Implementation
{
    public function raw(): Native;
    public function toString(): string;
    public function format(): string;
    public function optimize(): self;
}
