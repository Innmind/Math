<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\PrecisionMustBePositive;

/**
 * @psalm-immutable
 */
final class Round implements Number
{
    private Number $number;
    private int $precision;
    private int $mode;

    private function __construct(Number $number, int $precision, int $mode)
    {
        if ($precision < 0) {
            throw new PrecisionMustBePositive((string) $precision);
        }

        $this->number = $number;
        $this->precision = $precision;
        $this->mode = $mode;
    }

    /**
     * @psalm-pure
     */
    public static function up(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_UP);
    }

    /**
     * @psalm-pure
     */
    public static function down(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_DOWN);
    }

    /**
     * @psalm-pure
     */
    public static function even(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_EVEN);
    }

    /**
     * @psalm-pure
     */
    public static function odd(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_ODD);
    }

    public function value(): int|float
    {
        return $this->compute($this->number);
    }

    public function equals(Number $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(Number $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return Addition::of($this, $number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return Subtraction::of($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return Division::of($this, $number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return Multiplication::of($this, $number, ...$numbers);
    }

    public function roundUp(int $precision = 0): Number
    {
        return self::up($this, $precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return self::down($this, $precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return self::even($this, $precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return self::odd($this, $precision);
    }

    public function floor(): Number
    {
        return Floor::of($this);
    }

    public function ceil(): Number
    {
        return Ceil::of($this);
    }

    public function modulo(Number $modulus): Number
    {
        return Modulo::of($this, $modulus);
    }

    public function absolute(): Number
    {
        return Absolute::of($this);
    }

    public function power(Number $power): Number
    {
        return Power::of($this, $power);
    }

    public function squareRoot(): Number
    {
        return SquareRoot::of($this);
    }

    public function exponential(): Number
    {
        return Exponential::of($this);
    }

    public function binaryLogarithm(): Number
    {
        return BinaryLogarithm::of($this);
    }

    public function naturalLogarithm(): Number
    {
        return NaturalLogarithm::of($this);
    }

    public function commonLogarithm(): Number
    {
        return CommonLogarithm::of($this);
    }

    public function signum(): Number
    {
        return Signum::of($this);
    }

    public function collapse(): Number
    {
        return Number\Number::of($this->compute($this->number->collapse()));
    }

    public function toString(): string
    {
        return \var_export($this->value(), true);
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
