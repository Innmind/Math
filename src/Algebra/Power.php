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
    public function raw(): Native
    {
        return Native::of($this->number->raw()->value() ** $this->power->raw()->value());
    }

    #[\Override]
    public function optimize(): Implementation
    {
        $number = $this->number->optimize();
        $power = $this->power->optimize();

        if ($number instanceof SquareRoot && $power->raw()->is(Value::two)) {
            return $number->number()->optimize();
        }

        return new self(
            $number,
            $power,
        );
    }

    public function number(): Implementation
    {
        return $this->number;
    }

    public function square(): bool
    {
        return $this->power->optimize()->raw()->is(Value::two);
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
