<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use function Innmind\Math\asc;
use Innmind\Math\Algebra\Number;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Median implements Number
{
    private Number $result;

    private function __construct(Number $first, Number ...$values)
    {
        $sequence = Sequence::of($first, ...$values)->sort(asc(...));

        $this->result = match ($sequence->size() % 2) {
            1 => $this->odd($sequence),
            0 => $this->even($sequence),
        };
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $first, Number ...$values): self
    {
        return new self($first, ...$values);
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
        return $this;
    }

    public function toString(): string
    {
        return $this->result->toString();
    }

    /**
     * @param Sequence<Number> $values
     */
    private function odd(Sequence $values): Number
    {
        // mathematically the index to choose is (size+1/2) but here we
        // do (size-1)/2 as the sequence indexes start at 0
        return $values
            ->get(
                (int) (($values->size() - 1) / 2),
            )
            ->match(
                static fn($result) => $result,
                static fn() => throw new \LogicException,
            );
    }

    /**
     * @param Sequence<Number> $values
     */
    private function even(Sequence $values): Number
    {
        // mathematically the value is mean(size/2, size/2+1) but here we
        // do mean(size/2-1, size/2) as the sequence indexes start at 0
        $index = (int) ($values->size() / 2);

        return Mean::of(
            $values->get($index - 1)->match(
                static fn($number) => $number,
                static fn() => throw new \LogicException,
            ),
            $values->get($index)->match(
                static fn($number) => $number,
                static fn() => throw new \LogicException,
            ),
        );
    }
}
