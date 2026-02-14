<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class DisplayAs implements Implementation
{
    private function __construct(
        private Implementation $number,
        private string $string,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $number, string $string): self
    {
        return new self($number, $string);
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->number->value();
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->number->equals($number);
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return new self(
            $this->number->optimize(),
            $this->string,
        );
    }

    #[\Override]
    public function toString(): string
    {
        return $this->string;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }
}
