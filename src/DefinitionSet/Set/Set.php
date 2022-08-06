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

final class Set implements SetInterface
{
    /** @var Sequence<int|float> */
    private Sequence $values;

    /**
     * @no-named-arguments
     */
    public function __construct(Number ...$values)
    {
        $this->values = Sequence::of(...$values)->map(
            static fn(Number $v) => $v->value(),
        );
    }

    public function contains(Number $number): bool
    {
        return $this->values->contains($number->value());
    }

    public function accept(Number $number): void
    {
        if (!$this->contains($number)) {
            throw new OutOfDefinitionSet($this, $number);
        }
    }

    public function union(SetInterface $set): SetInterface
    {
        return new Union($this, $set);
    }

    public function intersect(SetInterface $set): SetInterface
    {
        return new Intersection($this, $set);
    }

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
