<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\NumberInterface;

final class Intersection implements SetInterface
{
    private $left;
    private $right;

    public function __construct(SetInterface $left, SetInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function contains(NumberInterface $number): bool
    {
        return $this->left->contains($number) &&
            $this->right->contains($number);
    }

    public function union(SetInterface $set): SetInterface
    {
        return new Union($this, $set);
    }

    public function intersect(SetInterface $set): SetInterface
    {
        return new self($this, $set);
    }

    public function __toString(): string
    {
        return $this->left.'∩'.$this->right;
    }
}
