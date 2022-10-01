<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
interface Operation
{
    public function result(): Number;
    public function toString(): string;
}
