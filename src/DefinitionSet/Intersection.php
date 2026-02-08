<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 * @internal
 */
final class Intersection implements Implementation
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
        return $this->left->contains($number) &&
            $this->right->contains($number);
    }

    #[\Override]
    public function toString(): string
    {
        return $this->left->toString().'∩'.$this->right->toString();
    }
}
