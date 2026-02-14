<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Ceil implements Implementation
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
    public function raw(): Native|Value
    {
        return Native::of(\ceil($this->number->raw()->value()));
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return new self($this->number->optimize());
    }

    #[\Override]
    public function toString(): string
    {
        return \var_export($this->raw()->value(), true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
