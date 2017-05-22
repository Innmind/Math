<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\PrecisionMustBePositive;

final class Round implements Number
{
    public const UP = 'UP';
    public const DOWN = 'DOWN';
    public const EVEN = 'EVEN';
    public const ODD = 'ODD';

    private $number;
    private $precision;
    private $mode;
    private $value;

    public function __construct(
        Number $number,
        int $precision = 0,
        string $mode = self::UP
    ) {
        if ($precision < 0) {
            throw new PrecisionMustBePositive;
        }

        $this->number = $number;
        $this->precision = $precision;
        $this->mode = constant('PHP_ROUND_HALF_'.$mode);
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value ?? $this->value = round(
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

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return new self($this, $precision, $mode);
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

    public function __toString(): string
    {
        return var_export($this->value(), true);
    }
}
