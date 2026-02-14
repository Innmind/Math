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
        $number = $this->number->optimize();

        if ($number instanceof Power && $number->square()) {
            return $number->number()->optimize();
        }

        return new self($number);
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
