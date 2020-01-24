<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Round
};
use Innmind\Immutable\Sequence;

final class Mean implements Number
{
    private $result;

    public function __construct(Number $first, Number ...$values)
    {
        $sequence = new Sequence($first, ...$values);
        $sum = $sequence
            ->drop(1)
            ->reduce(
                $sequence->first(),
                static function(Number $carry, Number $number): Number {
                    return $carry->add($number);
                }
            );
        $this->result = $sum->divideBy(new Number\Number($sequence->size()));
    }

    public function result(): Number
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->result->value();
    }

    public function equals(Number $number): bool
    {
        return $this->result->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->result->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->result->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->result->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->result->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->result->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return $this->result->round($precision, $mode);
    }

    public function floor(): Number
    {
        return $this->result->floor();
    }

    public function ceil(): Number
    {
        return $this->result->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->result->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->result->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->result->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->result->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->result->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->result->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->result->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->result->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->result->signum();
    }

    public function toString(): string
    {
        return $this->result->toString();
    }
}
