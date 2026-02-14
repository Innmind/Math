<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Signum implements Implementation
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
        return $this->number->value() <=> 0;
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
        return \sprintf('sgn(%s)', $this->number->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
