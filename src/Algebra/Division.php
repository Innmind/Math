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
        if ($divisor->optimize()->memoize()->is(Value::zero)) {
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
    public function memoize(): Native
    {
        return $this->quotient();
    }

    public function quotient(): Native
    {
        return Native::of(
            $this->dividend->memoize()->value() / $this->divisor->memoize()->value(),
        );
    }

    #[\Override]
    public function optimize(): Implementation
    {
        $dividend = $this->dividend->optimize();
        $divisor = $this->divisor->optimize();

        if (Value::one->is($divisor)) {
            return $dividend;
        }

        return new self(
            $dividend,
            $divisor,
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
}
