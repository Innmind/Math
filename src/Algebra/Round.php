<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Round implements Implementation
{
    /**
     * @param int<0, max> $precision
     * @param int<0, max> $mode
     */
    private function __construct(
        private Implementation $number,
        private int $precision,
        private int $mode,
    ) {
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
        return \round(
            $this->number->value(),
            $this->precision,
            $this->mode,
        );
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
            $this->number->optimize(),
            $this->precision,
            $this->mode,
        );
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
}
