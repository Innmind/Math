<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Round implements Implementation
{
    private Implementation $number;
    private int $precision;
    /** @var 0|positive-int */
    private int $mode;

    /**
     * @param int<0, max> $precision
     * @param 0|positive-int $mode
     */
    private function __construct(Implementation $number, int $precision, int $mode)
    {
        $this->number = $number;
        $this->precision = $precision;
        $this->mode = $mode;
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function up(Implementation $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_UP);
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function down(Implementation $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_DOWN);
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function even(Implementation $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_EVEN);
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function odd(Implementation $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_ODD);
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->compute($this->number);
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    #[\Override]
    public function collapse(): Implementation
    {
        return Native::of($this->compute($this->number->collapse()));
    }

    #[\Override]
    public function toString(): string
    {
        return \var_export($this->value(), true);
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }

    private function compute(Implementation $number): int|float
    {
        return \round(
            $number->value(),
            $this->precision,
            $this->mode,
        );
    }
}
