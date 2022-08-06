<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Round,
};
use Innmind\Immutable\Sequence;

final class Median implements Number
{
    private Number $result;

    public function __construct(Number $first, Number ...$values)
    {
        $sequence = Sequence::of(Number::class, $first, ...$values);
        $sequence = $sequence->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $a->higherThan($b) ? 1 : -1;
        });

        switch ($sequence->size() % 2) {
            case 1:
                //mathematically the index to choose is (size+1/2) but here we
                //do (size-1)/2 as the sequence indexes start at 0
                $this->result = $sequence->get(
                    (int) (($sequence->size() - 1) / 2),
                );
                break;

            default:
                //mathematically the value is mean(size/2, size/2+1) but here we
                //do mean(size/2-1, size/2) as the sequence indexes start at 0
                $index = (int) ($sequence->size() / 2);
                $this->result = new Mean(
                    $sequence->get($index - 1),
                    $sequence->get($index),
                );
                break;
        }
    }

    public function result(): Number
    {
        return $this->result;
    }

    public function value(): int|float
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

    public function roundUp(int $precision = 0): Number
    {
        return $this->result->roundUp($precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return $this->result->roundDown($precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return $this->result->roundEven($precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return $this->result->roundOdd($precision);
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
