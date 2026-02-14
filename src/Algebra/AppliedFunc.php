<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class AppliedFunc implements Implementation
{
    private function __construct(
        private Func $func,
        private Number $x,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Func $func, Number $x): self
    {
        return new self($func, $x);
    }

    #[\Override]
    public function value(): int|float
    {
        return ($this->func)($this->x)->value();
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
            $this->func,
            $this->x->optimize(),
        );
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf(
            '%s(%s)',
            $this->func->name(),
            $this->x->toString(),
        );
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }
}
