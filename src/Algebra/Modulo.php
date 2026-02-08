<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Modulo implements Implementation
{
    private function __construct(
        private Implementation $number,
        private Implementation $modulus,
    ) {
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
    public function optimize(): Implementation
    {
        return new self(
            $this->number->optimize(),
            $this->modulus->optimize(),
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
