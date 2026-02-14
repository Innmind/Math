<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZero;

/**
 * @psalm-immutable
 * @internal
 */
final class Division implements Implementation
{
    private Implementation $dividend;
    private Implementation $divisor;

    private function __construct(Implementation $dividend, Implementation $divisor)
    {
        if ($divisor->optimize()->value() == 0) {
            throw new DivisionByZero;
        }

        $this->dividend = $dividend;
        $this->divisor = $divisor;
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $dividend, Implementation $divisor): self
    {
        return new self($dividend, $divisor);
    }

    public function dividend(): Implementation
    {
        return $this->dividend;
    }

    public function divisor(): Implementation
    {
        return $this->divisor;
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->quotient()->value();
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    public function quotient(): Implementation
    {
        return $this->compute(
            $this->dividend,
            $this->divisor,
        );
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return new self(
            $this->dividend->optimize(),
            $this->divisor->optimize(),
        );
    }

    #[\Override]
    public function toString(): string
    {
        $dividend = $this->dividend->format();
        $divisor = $this->divisor->format();

        return \sprintf(
            '%s ÷ %s',
            $dividend,
            $divisor,
        );
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function compute(
        Implementation $dividend,
        Implementation $divisor,
    ): Implementation {
        return Native::of(
            $dividend->value() / $divisor->value(),
        );
    }
}
