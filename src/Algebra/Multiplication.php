<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\Sequence;
use function Innmind\Immutable\join;

final class Multiplication implements Operation, Number
{
    /** @var Sequence<Number> */
    private Sequence $values;
    private ?Number $result = null;

    public function __construct(
        Number $first,
        Number $second,
        Number ...$values
    ) {
        /** @var Sequence<Number> */
        $this->values = Sequence::of(Number::class, $first, $second, ...$values);
    }

    public function value()
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

    public function product(): Number
    {
        return $this->result();
    }

    public function result(): Number
    {
        if ($this->result) {
            return $this->result;
        }

        /**
         * @psalm-suppress MixedOperand
         * @psalm-suppress MissingClosureParamType
         * @psalm-suppress MissingClosureReturnType
         * @var callable(int|float, Number): (int|float)
         */
        $reduce = static function($carry, Number $number) {
            return $carry * $number->value();
        };

        /** @var int|float */
        $value = $this
            ->values
            ->drop(1)
            ->reduce(
                $this->values->first()->value(),
                $reduce,
            );

        return $this->result = Number\Number::wrap($value);
    }

    public function toString(): string
    {
        $values = $this->values->mapTo(
            'string',
            static function(Number $number) {
                if ($number instanceof Operation) {
                    return '('.$number->toString().')';
                }

                return $number->toString();
            },
        );

        return join(' x ', $values)->toString();
    }
}
