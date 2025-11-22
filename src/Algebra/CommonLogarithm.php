<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\DefinitionSet\Set;

/**
 * Base 10 logarithm
 * @psalm-immutable
 * @internal
 */
final class CommonLogarithm implements Implementation
{
    private Implementation $number;

    private function __construct(Implementation $number)
    {
        self::definitionSet()->accept(Number::of($number->value()));

        $this->number = $number;
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $number): self
    {
        return new self($number);
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->result()->value();
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    /**
     * @psalm-pure
     */
    public static function definitionSet(): Set
    {
        return Set::exclusiveRange(
            Number::zero(),
            Number::infinite(),
        );
    }

    #[\Override]
    public function collapse(): Implementation
    {
        return $this->compute($this->number->collapse());
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('lg(%s)', $this->number->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }

    private function result(): Implementation
    {
        return $this->compute($this->number);
    }

    private function compute(Implementation $number): Implementation
    {
        return Real::of(
            \log10($number->value()),
        );
    }
}
