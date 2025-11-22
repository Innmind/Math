<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Floor implements Implementation
{
    private Implementation $number;

    private function __construct(Implementation $number)
    {
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
        return $this->compute($this->number);
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    #[\Override]
    public function collapse(): Implementation
    {
        return Real::of($this->compute($this->number->collapse()));
    }

    #[\Override]
    public function toString(): string
    {
        return \var_export($this->value(), true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }

    private function compute(Implementation $number): int|float
    {
        return \floor($number->value());
    }
}
