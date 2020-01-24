<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\{
    Number,
    Integer
};

final class NaturalNumbers implements Set
{
    public function contains(Number $number): bool
    {
        if ((new Integer(0))->higherThan($number)) {
            return false;
        }

        if ($number instanceof Integer) {
            return true;
        }

        return $number
            ->modulo(new Integer(1))
            ->equals(new Integer(0));
    }

    public function union(Set $set): Set
    {
        return new Union($this, $set);
    }

    public function intersect(Set $set): Set
    {
        return new Intersection($this, $set);
    }

    public function toString(): string
    {
        return 'ℕ';
    }
}
