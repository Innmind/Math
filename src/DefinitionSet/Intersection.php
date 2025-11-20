<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};

/**
 * @psalm-immutable
 * @internal
 */
final class Intersection implements Implementation
{
    private Implementation $left;
    private Implementation $right;

    private function __construct(Implementation $left, Implementation $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $left, Implementation $right): self
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
    public function union(Implementation $set): Implementation
    {
        return Union::of($this, $set);
    }

    #[\Override]
    public function intersect(Implementation $set): Implementation
    {
        return new self($this, $set);
    }

    #[\Override]
    public function toString(): string
    {
        return $this->left->toString().'∩'.$this->right->toString();
    }
}
