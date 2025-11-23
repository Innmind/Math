<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 * @internal
 */
final class Addition implements Implementation
{
    /**
     * @param Sequence<Implementation> $values
     */
    private function __construct(
        private Sequence $values,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $first, Implementation $value): self
    {
        if ($first instanceof self) {
            $values = $first->values;
        } else {
            $values = Sequence::of($first);
        }

        return new self(($values)($value));
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->sum()->value();
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    public function sum(): Implementation
    {
        return $this->compute($this->values);
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return new self($this->values->map(
            static fn($value) => $value->optimize(),
        ));
    }

    #[\Override]
    public function toString(): string
    {
        $values = $this->values->map(
            static fn($number) => $number->format(),
        );

        return Str::of(' + ')->join($values)->toString();
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    /**
     * @param Sequence<Implementation> $values
     */
    private function compute(Sequence $values): Implementation
    {
        $value = $values->reduce(
            0,
            static fn(int|float $carry, $number): int|float => $carry + $number->value(),
        );

        return Native::of($value);
    }
}
