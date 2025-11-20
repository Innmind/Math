<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Round implements Number
{
    private Number $number;
    private int $precision;
    /** @var 0|positive-int */
    private int $mode;

    /**
     * @param int<0, max> $precision
     * @param 0|positive-int $mode
     */
    private function __construct(Number $number, int $precision, int $mode)
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
    public static function up(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_UP);
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function down(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_DOWN);
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function even(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_EVEN);
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $precision
     */
    public static function odd(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_ODD);
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->compute($this->number);
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->value() == $number->value();
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->value() > $number->value();
    }

    #[\Override]
    public function add(Number $number): Number
    {
        return Addition::of($this, $number);
    }

    #[\Override]
    public function subtract(Number $number): Number
    {
        return Subtraction::of($this, $number);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    #[\Override]
    public function multiplyBy(Number $number): Number
    {
        return Multiplication::of($this, $number);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return self::up($this, $precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return self::down($this, $precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return self::even($this, $precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return self::odd($this, $precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return Floor::of($this);
    }

    #[\Override]
    public function ceil(): Number
    {
        return Ceil::of($this);
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return Modulo::of($this, $modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return Absolute::of($this);
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return Power::of($this, $power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return SquareRoot::of($this);
    }

    #[\Override]
    public function exponential(): Number
    {
        return Exponential::of($this);
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return BinaryLogarithm::of($this);
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return NaturalLogarithm::of($this);
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return CommonLogarithm::of($this);
    }

    #[\Override]
    public function signum(): Number
    {
        return Signum::of($this);
    }

    #[\Override]
    public function collapse(): Number
    {
        return Real::of($this->compute($this->number->collapse()));
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

    private function compute(Number $number): int|float
    {
        return \round(
            $number->value(),
            $this->precision,
            $this->mode,
        );
    }
}
