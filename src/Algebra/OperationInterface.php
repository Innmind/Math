<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

interface OperationInterface
{
    public function result(): NumberInterface;
    public function __toString(): string;
}
