<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Modulo implements Implementation
{
    private Implementation $number;
    private Implementation $modulus;

    private function __construct(Implementation $number, Implementation $modulus)
    {
        $this->number = $number;
        $this->modulus = $modulus;
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $number, Implementation $modulus): self
    {
        return new self($number, $modulus);
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
    public function collapse(): Implementation
    {
        return $this->compute(
            $this->number->collapse(),
            $this->modulus->collapse(),
        );
    }

    #[\Override]
    public function toString(): string
    {
        $number = $this->number->format();
        $modulus = $this->modulus->format();

        return $number.' % '.$modulus;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function result(): Implementation
    {
        return $this->compute($this->number, $this->modulus);
    }

    private function compute(
        Implementation $number,
        Implementation $modulus,
    ): Implementation {
        return Native::of(
            \fmod($number->value(), $modulus->value()),
        );
    }
}
