<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\NumberInterface;
use Innmind\Immutable\Sequence;

final class Set implements SetInterface
{
    private $values;

    public function __construct(NumberInterface ...$values)
    {
        $this->values = (new Sequence(...$values))->map(function($v) {
            return $v->value();
        });
    }

    public function contains(NumberInterface $number): bool
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

    public function __toString(): string
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
