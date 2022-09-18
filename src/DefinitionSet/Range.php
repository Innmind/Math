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
final class Range implements Set
{
    private bool $lowerInclusivity;
    private bool $upperInclusivity;
    private Number $lower;
    private Number $upper;

    private function __construct(
        bool $lowerInclusivity,
        Number $lower,
        Number $upper,
        bool $upperInclusivity,
    ) {
        $this->lowerInclusivity = $lowerInclusivity;
        $this->lower = $lower;
        $this->upper = $upper;
        $this->upperInclusivity = $upperInclusivity;
    }

    public static function inclusive(Number $lower, Number $upper): self
    {
        return new self(true, $lower, $upper, true);
    }

    public static function exclusive(Number $lower, Number $upper): self
    {
        return new self(false, $lower, $upper, false);
    }

    public function excludeLowerBound(): self
    {
        return new self(false, $this->lower, $this->upper, $this->upperInclusivity);
    }

    public function excludeUpperBound(): self
    {
        return new self($this->lowerInclusivity, $this->lower, $this->upper, false);
    }

    public function contains(Number $number): bool
    {
        if ($this->lower->higherThan($number)) {
            return false;
        }

        if ($number->higherThan($this->upper)) {
            return false;
        }

        if (
            !$this->lowerInclusivity &&
            $this->lower->equals($number)
        ) {
            return false;
        }

        if (
            !$this->upperInclusivity &&
            $this->upper->equals($number)
        ) {
            return false;
        }

        return true;
    }

    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    public function union(Set $set): Set
    {
        return Union::of($this, $set);
    }

    public function intersect(Set $set): Set
    {
        return Intersection::of($this, $set);
    }

    public function toString(): string
    {
        return \sprintf(
            '%s%s;%s%s',
            $this->lowerInclusivity ? '[' : ']',
            $this->lower->toString(),
            $this->upper->toString(),
            $this->upperInclusivity ? ']' : '[',
        );
    }
}
