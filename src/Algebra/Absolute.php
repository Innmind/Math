<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Absolute implements Implementation
{
    private function __construct(private Implementation $number)
    {
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

    #[\Override]
    public function optimize(): Implementation
    {
        return new self($this->number->optimize());
    }

    #[\Override]
    public function toString(): string
    {
        return '|'.$this->number->toString().'|';
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function result(): Implementation
    {
        return $this->compute($this->number);
    }

    private function compute(Implementation $number): Implementation
    {
        return Native::of(
            \abs($number->value()),
        );
    }
}
