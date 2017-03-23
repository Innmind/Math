<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

interface NumberInterface
{
    /**
     * @return int|float
     */
    public function value();
    public function equals(self $number): bool;
    public function higherThan(self $number): bool;
    public function __toString(): string;
}
