<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class SquareRoot implements Implementation
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
        if ($this->number instanceof Power && $this->number->square()) {
            return $this->number->number()->optimize();
        }

        return $this;
    }

    public function number(): Implementation
    {
        return $this->number;
    }

    #[\Override]
    public function toString(): string
    {
        $number = $this->number->format();

        return '√'.$number;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function result(): Implementation
    {
        return Native::of(
            \sqrt($this->number->value()),
        );
    }
}
