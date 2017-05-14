<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\{
    NumberInterface,
    Integer
};

final class Integers implements SetInterface
{
    public function contains(NumberInterface $number): bool
    {
        if ($number instanceof Integer) {
            return true;
        }

        return $number
            ->modulo(new Integer(1))
            ->equals(new Integer(0));
    }

    public function union(SetInterface $set): SetInterface
    {
        return new Union($this, $set);
    }

    public function intersect(SetInterface $set): SetInterface
    {
        return new Intersection($this, $set);
    }

    public function __toString(): string
    {
        return 'ℤ';
    }
}
