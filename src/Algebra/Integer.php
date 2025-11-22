<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Integer implements Implementation
{
    private int $value;

    final private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function of(int $value): self
    {
        return new self($value);
    }

    #[\Override]
    public function value(): int
    {
        return $this->value;
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value == $number->value();
    }

    #[\Override]
    public function collapse(): Implementation
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        return \var_export($this->value, true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
