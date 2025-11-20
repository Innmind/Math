<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet\Set;

use Innmind\Math\{
    DefinitionSet\Set as SetInterface,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Set implements SetInterface
{
    /** @var Sequence<int|float> */
    private Sequence $values;

    /**
     * @no-named-arguments
     */
    private function __construct(Number ...$values)
    {
        $this->values = Sequence::of(...$values)->map(
            static fn(Number $v) => $v->value(),
        );
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Number ...$values): self
    {
        return new self(...$values);
    }

    #[\Override]
    public function contains(Number $number): bool
    {
        return $this->values->contains($number->value());
    }

    #[\Override]
    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    #[\Override]
    public function union(SetInterface $set): SetInterface
    {
        return Union::of($this, $set);
    }

    #[\Override]
    public function intersect(SetInterface $set): SetInterface
    {
        return Intersection::of($this, $set);
    }

    #[\Override]
    public function toString(): string
    {
        if ($this->values->size() === 0) {
            return '∅';
        }

        /** @var Sequence<string> */
        $values = $this->values->map(
            static fn($number): string => (string) $number,
        );

        return Str::of(';')
            ->join($values)
            ->prepend('{')
            ->append('}')
            ->toString();
    }
}
