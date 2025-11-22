<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class Number
{
    private function __construct(
        private Implementation $implementation,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(int|float $value): self
    {
        if (\is_int($value)) {
            return new self(Integer::of($value));
        }

        return new self(Real::of($value));
    }

    /**
     * @psalm-pure
     */
    public static function zero(): self
    {
        return new self(Value::zero);
    }

    /**
     * @psalm-pure
     */
    public static function one(): self
    {
        return new self(Value::one);
    }

    /**
     * @psalm-pure
     */
    public static function two(): self
    {
        return new self(Value::two);
    }

    /**
     * @psalm-pure
     */
    public static function ten(): self
    {
        return new self(Value::ten);
    }

    /**
     * @psalm-pure
     */
    public static function hundred(): self
    {
        return new self(Value::hundred);
    }

    /**
     * @psalm-pure
     */
    public static function e(): self
    {
        return new self(Value::e);
    }

    /**
     * @psalm-pure
     */
    public static function pi(): self
    {
        return new self(Value::pi);
    }

    /**
     * @psalm-pure
     */
    public static function infinite(): self
    {
        return new self(Value::infinite);
    }

    /**
     * @psalm-pure
     */
    public static function negativeInfinite(): self
    {
        return new self(Value::negativeInfinite);
    }

    public function value(): int|float
    {
        return $this->implementation->value();
    }

    public function equals(self $number): bool
    {
        return $this->implementation->equals(
            $number->implementation,
        );
    }

    public function higherThan(self $number): bool
    {
        return $this->value() > $number->value();
    }

    public function add(self $number): self
    {
        return new self(Addition::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    public function subtract(self $number): self
    {
        return new self(Subtraction::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    public function divideBy(self $number): self
    {
        return new self(Division::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    public function multiplyBy(self $number): self
    {
        return new self(Multiplication::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    /**
     * @param int<0, max> $precision
     */
    public function roundUp(int $precision = 0): self
    {
        return new self(Round::up(
            $this->implementation,
            $precision,
        ));
    }

    /**
     * @param int<0, max> $precision
     */
    public function roundDown(int $precision = 0): self
    {
        return new self(Round::down(
            $this->implementation,
            $precision,
        ));
    }

    /**
     * @param int<0, max> $precision
     */
    public function roundEven(int $precision = 0): self
    {
        return new self(Round::even(
            $this->implementation,
            $precision,
        ));
    }

    /**
     * @param int<0, max> $precision
     */
    public function roundOdd(int $precision = 0): self
    {
        return new self(Round::odd(
            $this->implementation,
            $precision,
        ));
    }

    public function floor(): self
    {
        return new self(Floor::of($this->implementation));
    }

    public function ceil(): self
    {
        return new self(Ceil::of($this->implementation));
    }

    public function modulo(self $modulus): self
    {
        return new self(Modulo::of(
            $this->implementation,
            $modulus->implementation,
        ));
    }

    public function absolute(): self
    {
        return new self(Absolute::of($this->implementation));
    }

    public function power(self $power): self
    {
        return new self(Power::of(
            $this->implementation,
            $power->implementation,
        ));
    }

    public function squareRoot(): self
    {
        return new self(SquareRoot::of(
            $this->implementation,
        ));
    }

    public function exponential(): self
    {
        return new self(Exponential::of(
            $this->implementation,
        ));
    }

    public function binaryLogarithm(): self
    {
        return new self(BinaryLogarithm::of(
            $this->implementation,
        ));
    }

    public function naturalLogarithm(): self
    {
        return new self(NaturalLogarithm::of(
            $this->implementation,
        ));
    }

    public function commonLogarithm(): self
    {
        return new self(CommonLogarithm::of(
            $this->implementation,
        ));
    }

    public function signum(): self
    {
        return new self(Signum::of($this->implementation));
    }

    public function toString(): string
    {
        return $this->implementation->toString();
    }

    public function format(): string
    {
        return $this->implementation->format();
    }

    /**
     * Compute the underlying number like the value() method but it will try to
     * skip some operations to provide the most accurate number
     *
     * For example instead of computing each operation of `sqrt(square(x))` it
     * will directly return `x`
     */
    public function collapse(): self
    {
        return new self($this->implementation->collapse());
    }
}
