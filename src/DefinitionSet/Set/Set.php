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

final class Set implements SetInterface
{
    private Sequence $values;

    public function __construct(Number ...$values)
    {
        $this->values = (new Sequence(...$values))->map(static function(Number $v) {
            return $v->value();
        });
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

        return (string) $this
            ->values
            ->join(';')
            ->prepend('{')
            ->append('}');
    }
}
