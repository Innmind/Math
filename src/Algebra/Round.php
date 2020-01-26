<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\PrecisionMustBePositive;

final class Round implements Number
{
    private Number $number;
    private int $precision;
    private int $mode;
    /** @var int|float|null */
    private $value;

    private function __construct(
        Number $number,
        int $precision,
        int $mode
    ) {
        if ($precision < 0) {
            throw new PrecisionMustBePositive((string) $precision);
        }

        $this->number = $number;
        $this->precision = $precision;
        $this->mode = $mode;
    }

    public static function up(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_UP);
    }

    public static function down(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_DOWN);
    }

    public static function even(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_EVEN);
    }

    public static function odd(Number $number, int $precision = 0): self
    {
        return new self($number, $precision, \PHP_ROUND_HALF_ODD);
    }

    public function value()
    {
        return $this->value ??= round(
            $this->number->value(),
            $this->precision,
            $this->mode
        );
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
        return new Addition($this, $number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return new Subtraction($this, $number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return new Division($this, $number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return new Multiplication($this, $number, ...$numbers);
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
        return new Floor($this);
    }

    public function ceil(): Number
    {
        return new Ceil($this);
    }

    public function modulo(Number $modulus): Number
    {
        return new Modulo($this, $modulus);
    }

    public function absolute(): Number
    {
        return new Absolute($this);
    }

    public function power(Number $power): Number
    {
        return new Power($this, $power);
    }

    public function squareRoot(): Number
    {
        return new SquareRoot($this);
    }

    public function exponential(): Number
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): Number
    {
        return new BinaryLogarithm($this);
    }

    public function naturalLogarithm(): Number
    {
        return new NaturalLogarithm($this);
    }

    public function commonLogarithm(): Number
    {
        return new CommonLogarithm($this);
    }

    public function signum(): Number
    {
        return new Signum($this);
    }

    public function toString(): string
    {
        return var_export($this->value(), true);
    }
}
