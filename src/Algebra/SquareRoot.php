<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class SquareRoot implements Implementation
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
    public function raw(): Native
    {
        return Native::of(\sqrt($this->number->raw()->value()));
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
}
