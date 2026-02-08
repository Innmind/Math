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
final class Union implements Implementation
{
    private function __construct(
        private Implementation $left,
        private Implementation $right,
    ) {
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
        return $this->left->contains($number) ||
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
    public function toString(): string
    {
        return $this->left->toString().'∪'.$this->right->toString();
    }
}
