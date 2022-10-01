<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Multiplication implements Operation, Number
{
    private Number $first;
    private Number $second;
    /** @var Sequence<Number> */
    private Sequence $values;

    private function __construct(
        Number $first,
        Number $second,
        Number ...$values,
    ) {
        $this->first = $first;
        $this->second = $second;
        $this->values = Sequence::of($first, $second, ...$values);
    }

    /**
     * @psalm-pure
     */
    public static function of(
        Number $first,
        Number $second,
        Number ...$values,
    ): self {
        return new self($first, $second, ...$values);
    }

    public function value(): int|float
    {
        return $this->result()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->result()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->result()->higherThan($number);
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

    public function multiplyBy(Number $number, Number ...$numbers): self
    {
        return new self($this, $number, ...$numbers);
    }

    public function roundUp(int $precision = 0): Number
    {
        return Round::up($this, $precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return Round::down($this, $precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return Round::even($this, $precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return Round::odd($this, $precision);
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

    public function product(): Number
    {
        return $this->result();
    }

    public function result(): Number
    {
        $value = $this->values->reduce(
            1,
            static fn(int|float $carry, $number): int|float => $carry * $number->value(),
        );

        return Real::of($value);
    }

    public function collapse(): Number
    {
        return $this
            ->values
            ->drop(2)
            ->reduce(
                $this->doCollapse($this->first, $this->second),
                $this->doCollapse(...),
            )
            ->collapse();
    }

    public function toString(): string
    {
        $values = $this->values->map(
            static function(Number $number) {
                if ($number instanceof Operation) {
                    return '('.$number->toString().')';
                }

                return $number->toString();
            },
        );

        return Str::of(' x ')->join($values)->toString();
    }

    private function doCollapse(Number $a, Number $b): Number
    {
        if ($a instanceof Division) {
            $divisor = $a->divisor()->collapse();

            if ($b->equals($divisor)) {
                return $a->dividend();
            }
        }

        if ($b instanceof Division) {
            $divisor = $b->divisor()->collapse();

            if ($a->equals($divisor)) {
                return $b->dividend();
            }
        }

        return (new self($a->collapse(), $b->collapse()))->result();
    }
}
