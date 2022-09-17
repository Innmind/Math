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

    public function __construct(int|float $value)
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
            return new Integer($value);
        }

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
        return new Addition($this, $number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers,
    ): NumberInterface {
        return new Subtraction($this, $number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new Division($this, $number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers,
    ): NumberInterface {
        return new Multiplication($this, $number, ...$numbers);
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
        return new Floor($this);
    }

    public function ceil(): NumberInterface
    {
        return new Ceil($this);
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return new Modulo($this, $modulus);
    }

    public function absolute(): NumberInterface
    {
        return new Absolute($this);
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return new Power($this, $power);
    }

    public function squareRoot(): NumberInterface
    {
        return new SquareRoot($this);
    }

    public function exponential(): NumberInterface
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): NumberInterface
    {
        return new BinaryLogarithm($this);
    }

    public function naturalLogarithm(): NumberInterface
    {
        return new NaturalLogarithm($this);
    }

    public function commonLogarithm(): NumberInterface
    {
        return new CommonLogarithm($this);
    }

    public function signum(): NumberInterface
    {
        return new Signum($this);
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
