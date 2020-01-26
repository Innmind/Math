<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet\Set;

use Innmind\Math\{
    DefinitionSet\Set as SetInterface,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Number
};
use Innmind\Immutable\Sequence;
use function Innmind\Immutable\join;

final class Set implements SetInterface
{
    /** @var Sequence<int|float> */
    private Sequence $values;

    public function __construct(Number ...$values)
    {
        $this->values = Sequence::mixed(...$values)->mapTo(
            'int|float',
            static fn(Number $v) => $v->value(),
        );
    }

    public function contains(Number $number): bool
    {
        return $this->values->contains($number->value());
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

        $values = $this->values->mapTo(
            'string',
            static fn($number): string => (string) $number,
        );

        return join(';', $values)
            ->prepend('{')
            ->append('}')
            ->toString();
    }
}
