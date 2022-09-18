<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra\Number;

use Innmind\Math\{
    Algebra\Number as NumberInterface,
    Algebra\Integer,
    Algebra\Absolute,
    Algebra\Addition,
    Algebra\BinaryLogarithm,
    Algebra\Ceil,
    Algebra\CommonLogarithm,
    Algebra\Division,
    Algebra\Exponential,
    Algebra\Floor,
    Algebra\Modulo,
    Algebra\Multiplication,
    Algebra\NaturalLogarithm,
    Algebra\Power,
    Algebra\Round,
    Algebra\Signum,
    Algebra\SquareRoot,
    Algebra\Subtraction,
    Exception\NotANumber,
};

/**
 * @psalm-immutable
 */
final class Number implements NumberInterface
{
    private int|float $value;

    private function __construct(int|float $value)
    {
        if (\is_nan($value)) {
            throw new NotANumber;
        }

        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function of(int|float $value): NumberInterface
    {
        if (\is_infinite($value)) {
            return $value > 0 ? Infinite::positive() : Infinite::negative();
        }

        if (\is_int($value)) {
            return Integer::of($value);
        }

        return new self($value);
    }

    /**
     * @psalm-pure
     */
    public static function int(int $value): self
    {
        return new self($value);
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
        return \var_export($this->value, true);
    }
}
