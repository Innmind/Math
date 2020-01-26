<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

interface Operation
{
    public function result(): Number;
    public function toString(): string;
}
