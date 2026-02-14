<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\Immutable\{
    Attempt,
    SideEffect,
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
    #[\NoDiscard]
    public static function of(Number ...$values): self
    {
        return new self(Values::of(...$values));
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function integers(): self
    {
        return new self(new Integers);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function integersExceptZero(): self
    {
        return new self(new IntegersExceptZero);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function naturalNumbers(): self
    {
        return new self(new NaturalNumbers);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function naturalNumbersExceptZero(): self
    {
        return new self(new NaturalNumbersExceptZero);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function realNumbers(): self
    {
        return new self(new RealNumbers);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function realNumbersExceptZero(): self
    {
        return new self(new RealNumbersExceptZero);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function inclusiveRange(Number $lower, Number $upper): self
    {
        return new self(Range::inclusive($lower, $upper));
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function exclusiveRange(Number $lower, Number $upper): self
    {
        return new self(Range::exclusive($lower, $upper));
    }

    /**
     * ∈ or ∉
     */
    #[\NoDiscard]
    public function contains(Number $number): bool
    {
        return $this->implementation->contains($number);
    }

    /**
     * @return Attempt<SideEffect>
     */
    #[\NoDiscard]
    public function accept(Number $number): Attempt
    {
        if (!$this->contains($number)) {
            return Attempt::error(new OutOfDefinitionSet($this->implementation, $number));
        }

        return Attempt::result(SideEffect::identity);
    }

    #[\NoDiscard]
    public function union(self $set): self
    {
        return new self(Union::of(
            $this->implementation,
            $set->implementation,
        ));
    }

    #[\NoDiscard]
    public function intersect(self $set): self
    {
        return new self(Intersection::of(
            $this->implementation,
            $set->implementation,
        ));
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return $this->implementation->toString();
    }
}
