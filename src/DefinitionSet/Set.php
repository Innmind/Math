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
final class Set
{
    private function __construct(
        private Implementation $implementation,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Number ...$values): self
    {
        return new self(Values::of(...$values));
    }

    /**
     * @psalm-pure
     */
    public static function integers(): self
    {
        return new self(new Integers);
    }

    /**
     * @psalm-pure
     */
    public static function integersExceptZero(): self
    {
        return new self(new IntegersExceptZero);
    }

    /**
     * @psalm-pure
     */
    public static function naturalNumbers(): self
    {
        return new self(new NaturalNumbers);
    }

    /**
     * @psalm-pure
     */
    public static function naturalNumbersExceptZero(): self
    {
        return new self(new NaturalNumbersExceptZero);
    }

    /**
     * @psalm-pure
     */
    public static function realNumbers(): self
    {
        return new self(new RealNumbers);
    }

    /**
     * @psalm-pure
     */
    public static function realNumbersExceptZero(): self
    {
        return new self(new RealNumbersExceptZero);
    }

    /**
     * @psalm-pure
     */
    public static function inclusiveRange(Number $lower, Number $upper): self
    {
        return new self(Range::inclusive($lower, $upper));
    }

    /**
     * @psalm-pure
     */
    public static function exclusiveRange(Number $lower, Number $upper): self
    {
        return new self(Range::exclusive($lower, $upper));
    }

    /**
     * ∈ or ∉
     */
    public function contains(Number $number): bool
    {
        return $this->implementation->contains($number);
    }

    /**
     * @throws OutOfDefinitionSet
     */
    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this->implementation, $number);
        }
    }

    public function union(self $set): self
    {
        return new self(Union::of(
            $this->implementation,
            $set->implementation,
        ));
    }

    public function intersect(self $set): self
    {
        return new self(Intersection::of(
            $this->implementation,
            $set->implementation,
        ));
    }

    public function toString(): string
    {
        return $this->implementation->toString();
    }
}
