<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Round,
};
use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Scope implements Number
{
    private Number $result;

    public function __construct(
        Number $first,
        Number $second,
        Number ...$values,
    ) {
        $sequence = Sequence::of($first, $second, ...$values);
        $sequence = $sequence->sort(static function(Number $a, Number $b): int {
            if ($a->equals($b)) {
                return 0;
            }

            return $a->higherThan($b) ? 1 : -1;
        });
        $this->result = Maybe::all($sequence->last(), $sequence->first())
            ->map(static fn(Number $last, Number $first) => $last->subtract($first))
            ->match(
                static fn($result) => $result,
                static fn() => throw new \LogicException('Unreachable'),
            );
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

    public function collapse(): Number
    {
        return $this->result->collapse();
    }

    public function toString(): string
    {
        return $this->result->toString();
    }
}
