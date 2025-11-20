<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\{
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 * @internal
 */
final class Values implements Implementation
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
    public function union(Implementation $set): Implementation
    {
        return Union::of($this, $set);
    }

    #[\Override]
    public function intersect(Implementation $set): Implementation
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
