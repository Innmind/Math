<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Integer,
    Addition,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Mean implements Number
{
    private Number $result;

    private function __construct(Number $first, Number ...$values)
    {
        $sequence = Sequence::of($first, ...$values);
        $sum = Addition::of($first, ...$values);
        $this->result = $sum->divideBy(Integer::of($sequence->size()));
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

    #[\Override]
    public function value(): int|float
    {
        return $this->result->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->result->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->result->higherThan($number);
    }

    #[\Override]
    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->result->add($number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->result->subtract($number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->result->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->result->multiplyBy($number, ...$numbers);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->result->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->result->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->result->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->result->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->result->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->result->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->result->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->result->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->result->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->result->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->result->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->result->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->result->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->result->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->result->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this->result->collapse();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->result->toString();
    }

    #[\Override]
    public function format(): string
    {
        return $this->result->format();
    }
}
