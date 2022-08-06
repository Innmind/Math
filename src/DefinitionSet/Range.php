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
    public const INCLUSIVE = true;
    public const EXCLUSIVE = false;

    private bool $lowerInclusivity;
    private bool $upperInclusivity;
    private Number $lower;
    private Number $upper;

    public function __construct(
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
        return new self(self::INCLUSIVE, $lower, $upper, self::INCLUSIVE);
    }

    public static function exclusive(Number $lower, Number $upper): self
    {
        return new self(self::EXCLUSIVE, $lower, $upper, self::EXCLUSIVE);
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
            $this->lowerInclusivity === self::EXCLUSIVE &&
            $this->lower->equals($number)
        ) {
            return false;
        }

        if (
            $this->upperInclusivity === self::EXCLUSIVE &&
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
        return new Union($this, $set);
    }

    public function intersect(Set $set): Set
    {
        return new Intersection($this, $set);
    }

    public function toString(): string
    {
        return \sprintf(
            '%s%s;%s%s',
            $this->lowerInclusivity === self::INCLUSIVE ? '[' : ']',
            $this->lower->toString(),
            $this->upper->toString(),
            $this->upperInclusivity === self::INCLUSIVE ? ']' : '[',
        );
    }
}
