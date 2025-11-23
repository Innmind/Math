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
final class Subtraction implements Implementation
{
    /**
     * @param Sequence<Implementation> $values
     */
    private function __construct(
        private Implementation $first,
        private Sequence $values,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $first, Implementation $second): self
    {
        if ($first instanceof self) {
            if ($second instanceof self) {
                return new self(
                    $first->first,
                    $first->values->append($second->values),
                );
            }

            return new self(
                $first->first,
                ($first->values)($second),
            );
        }

        return new self($first, Sequence::of($first, $second));
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->difference()->value();
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    public function difference(): Implementation
    {
        return $this->compute($this->first, $this->values);
    }

    #[\Override]
    public function collapse(): Implementation
    {
        return $this->compute(
            $this->first->collapse(),
            $this->values->map(static fn($value) => $value->collapse()),
        );
    }

    #[\Override]
    public function toString(): string
    {
        $values = $this->values->map(
            static fn($number) => $number->format(),
        );

        return Str::of(' - ')->join($values)->toString();
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    /**
     * @param Sequence<Implementation> $values
     */
    private function compute(Implementation $first, Sequence $values): Implementation
    {
        $value = $values
            ->drop(1)
            ->reduce(
                $first->value(),
                static fn(int|float $carry, $number): int|float => $carry - $number->value(),
            );

        return Native::of($value);
    }
}
