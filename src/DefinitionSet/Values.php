<?php
declare(strict_types = 1);

namespace Innmind\Math\DefinitionSet;

use Innmind\Math\Algebra\Number;
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
    /**
     * @param Sequence<int|float> $values
     */
    private function __construct(private Sequence $values)
    {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Number ...$values): self
    {
        return new self(Sequence::of(...$values)->map(
            static fn(Number $v) => $v->value(),
        ));
    }

    #[\Override]
    public function contains(Number $number): bool
    {
        return $this->values->contains($number->value());
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
