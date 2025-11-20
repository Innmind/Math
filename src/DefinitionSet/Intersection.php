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

    private function __construct(Set $left, Set $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @psalm-pure
     */
    public static function of(Set $left, Set $right): self
    {
        return new self($left, $right);
    }

    #[\Override]
    public function contains(Number $number): bool
    {
        return $this->left->contains($number) &&
            $this->right->contains($number);
    }

    #[\Override]
    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    #[\Override]
    public function union(Set $set): Set
    {
        return Union::of($this, $set);
    }

    #[\Override]
    public function intersect(Set $set): Set
    {
        return new self($this, $set);
    }

    #[\Override]
    public function toString(): string
    {
        return $this->left->toString().'∩'.$this->right->toString();
    }
}
