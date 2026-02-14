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
    #[\NoDiscard]
    public static function of(int|float $value): self
    {
        return new self(Native::of($value));
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function zero(): self
    {
        return new self(Value::zero);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function one(): self
    {
        return new self(Value::one);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function two(): self
    {
        return new self(Value::two);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function ten(): self
    {
        return new self(Value::ten);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function hundred(): self
    {
        return new self(Value::hundred);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function e(): self
    {
        return new self(Value::e);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function pi(): self
    {
        return new self(Value::pi);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function infinite(): self
    {
        return new self(Value::infinite);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function negativeInfinite(): self
    {
        return new self(Value::negativeInfinite);
    }

    #[\NoDiscard]
    public function apply(Func $func): self
    {
        return new self(AppliedFunc::of($func, $this));
    }

    #[\NoDiscard]
    public function value(): int|float
    {
        return $this->implementation->value();
    }

    #[\NoDiscard]
    public function equals(self $number): bool
    {
        return $this->implementation->equals(
            $number->implementation,
        );
    }

    #[\NoDiscard]
    public function higherThan(self $number): bool
    {
        return $this->value() > $number->value();
    }

    #[\NoDiscard]
    public function add(self $number): self
    {
        return new self(Addition::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    #[\NoDiscard]
    public function subtract(self $number): self
    {
        return new self(Subtraction::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    #[\NoDiscard]
    public function divideBy(self $number): self
    {
        return new self(Division::of(
            $this->implementation,
            $number->implementation,
        ));
    }

    #[\NoDiscard]
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
    #[\NoDiscard]
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
    #[\NoDiscard]
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
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function roundOdd(int $precision = 0): self
    {
        return new self(Round::odd(
            $this->implementation,
            $precision,
        ));
    }

    #[\NoDiscard]
    public function floor(): self
    {
        return new self(Floor::of($this->implementation));
    }

    #[\NoDiscard]
    public function ceil(): self
    {
        return new self(Ceil::of($this->implementation));
    }

    #[\NoDiscard]
    public function modulo(self $modulus): self
    {
        return new self(Modulo::of(
            $this->implementation,
            $modulus->implementation,
        ));
    }

    #[\NoDiscard]
    public function absolute(): self
    {
        return new self(Absolute::of($this->implementation));
    }

    #[\NoDiscard]
    public function power(self $power): self
    {
        return new self(Power::of(
            $this->implementation,
            $power->implementation,
        ));
    }

    #[\NoDiscard]
    public function squareRoot(): self
    {
        return new self(SquareRoot::of(
            $this->implementation,
        ));
    }

    #[\NoDiscard]
    public function exponential(): self
    {
        return new self(Exponential::of(
            $this->implementation,
        ));
    }

    #[\NoDiscard]
    public function signum(): self
    {
        return new self(Signum::of($this->implementation));
    }

    /**
     * This allows to change the way the number is represented as a string.
     *
     * You can use this to display a number as a name instead of the real value.
     */
    #[\NoDiscard]
    public function as(string $string): self
    {
        return new self(DisplayAs::of(
            $this->implementation,
            $string,
        ));
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return $this->implementation->toString();
    }

    #[\NoDiscard]
    public function format(): string
    {
        return $this->implementation->format();
    }

    /**
     * This method will remove unnecessary operations in order to have the most
     * precise number in the end.
     *
     * For example instead of computing each operation of `sqrt(square(x))` it
     * will directly return `x`
     */
    #[\NoDiscard]
    public function optimize(): self
    {
        return new self($this->implementation->optimize());
    }

    /**
     * This prevents recomputing the underlying operations each time the result
     * is accessed.
     */
    #[\NoDiscard]
    public function memoize(): self
    {
        if ($this->implementation instanceof Native) {
            return $this;
        }

        return self::of($this->value());
    }
}
