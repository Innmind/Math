<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Exponential implements Implementation
{
    private function __construct(private Implementation $power)
    {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $power): self
    {
        return new self($power);
    }

    #[\Override]
    public function raw(): Native
    {
        return Native::of(\exp($this->power->raw()->value()));
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return new self($this->power->optimize());
    }

    #[\Override]
    public function toString(): string
    {
        $power = $this->power->format();

        return 'e^'.$power;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }
}
