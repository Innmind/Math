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
    public function memoize(): Native
    {
        return Native::of($this->number->memoize()->value() ** $this->power->memoize()->value());
    }

    #[\Override]
    public function optimize(): Implementation
    {
        $number = $this->number->optimize();
        $power = $this->power->optimize();

        if ($number instanceof SquareRoot && Value::two->is($power)) {
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
        return Value::two->is($this->power->optimize());
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
