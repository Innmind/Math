<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 */
final class Intersection implements Set
{
    private Set $left;
    private Set $right;

    public function __construct(Set $left, Set $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function contains(Number $number): bool
    {
        return $this->left->contains($number) &&
            $this->right->contains($number);
    }

    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    public function union(Set $set): Set
    {
        return new Union($this, $set);
    }

    public function intersect(Set $set): Set
    {
        return new self($this, $set);
    }

    public function toString(): string
    {
        return $this->left->toString().'∩'.$this->right->toString();
    }
}
