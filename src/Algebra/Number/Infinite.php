<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    Number as NumberInterface,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
};

/**
 * @psalm-immutable
 */
final class Infinite implements NumberInterface
{
    private float $value;

    private function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function positive(): self
    {
        return new self(\INF);
    }

    /**
     * @psalm-pure
     */
    public static function negative(): self
    {
        return new self(-\INF);
    }

    public function value(): int|float
    {
        return $this->value;
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers,
    ): NumberInterface {
        return Addition::of($this, $number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers,
    ): NumberInterface {
        return Subtraction::of($this, $number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return Division::of($this, $number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers,
    ): NumberInterface {
        return Multiplication::of($this, $number, ...$numbers);
    }

    public function roundUp(int $precision = 0): NumberInterface
    {
        return Round::up($this, $precision);
    }

    public function roundDown(int $precision = 0): NumberInterface
    {
        return Round::down($this, $precision);
    }

    public function roundEven(int $precision = 0): NumberInterface
    {
        return Round::even($this, $precision);
    }

    public function roundOdd(int $precision = 0): NumberInterface
    {
        return Round::odd($this, $precision);
    }

    public function floor(): NumberInterface
    {
        return Floor::of($this);
    }

    public function ceil(): NumberInterface
    {
        return Ceil::of($this);
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return Modulo::of($this, $modulus);
    }

    public function absolute(): NumberInterface
    {
        return Absolute::of($this);
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return Power::of($this, $power);
    }

    public function squareRoot(): NumberInterface
    {
        return SquareRoot::of($this);
    }

    public function exponential(): NumberInterface
    {
        return Exponential::of($this);
    }

    public function binaryLogarithm(): NumberInterface
    {
        return BinaryLogarithm::of($this);
    }

    public function naturalLogarithm(): NumberInterface
    {
        return NaturalLogarithm::of($this);
    }

    public function commonLogarithm(): NumberInterface
    {
        return CommonLogarithm::of($this);
    }

    public function signum(): NumberInterface
    {
        return Signum::of($this);
    }

    public function collapse(): NumberInterface
    {
        return $this;
    }

    public function toString(): string
    {
        return $this->value() > 0 ? '+∞' : '-∞';
    }
}
