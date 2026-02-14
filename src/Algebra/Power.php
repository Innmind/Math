<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Power implements Implementation
{
    private function __construct(
        private Implementation $number,
        private Implementation $power,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $number, Implementation $power): self
    {
        return new self($number, $power);
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->number->value() ** $this->power->value();
    }

    #[\Override]
    public function raw(): Native|Value
    {
        return Native::of($this->value());
    }

    #[\Override]
    public function optimize(): Implementation
    {
        if ($this->number instanceof SquareRoot && $this->square()) {
            return $this->number->number()->optimize();
        }

        return $this;
    }

    public function number(): Implementation
    {
        return $this->number;
    }

    public function square(): bool
    {
        return $this->power->raw()->equals(Value::two);
    }

    #[\Override]
    public function toString(): string
    {
        $number = $this->number->format();
        $power = $this->power->format();

        return $number.'^'.$power;
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }
}
