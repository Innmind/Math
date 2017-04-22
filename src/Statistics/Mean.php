<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    NumberInterface,
    Number,
    Round
};
use Innmind\Immutable\Sequence;

final class Mean implements NumberInterface
{
    private $result;

    public function __construct(
        NumberInterface $first,
        NumberInterface ...$values
    ) {
        $sequence = new Sequence($first, ...$values);
        $sum = $sequence
            ->drop(1)
            ->reduce(
                $sequence->first(),
                function(NumberInterface $carry, NumberInterface $number): NumberInterface {
                    return $carry->add($number);
                }
            );
        $this->result = $sum->divideBy(new Number($sequence->size()));
    }

    public function result(): NumberInterface
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

    public function equals(NumberInterface $number): bool
    {
        return $this->result->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->result->higherThan($number);
    }

    public function add(NumberInterface ...$numbers): NumberInterface
    {
        return $this->result->add(...$numbers);
    }

    public function subtract(NumberInterface ...$numbers): NumberInterface
    {
        return $this->result->subtract(...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->result->divideBy($number);
    }

    public function multiplyBy(NumberInterface $number): NumberInterface
    {
        return $this->result->multiplyBy($number);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->result->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->result->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->result->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->result->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->result->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->result->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->result->squareRoot();
    }

    public function __toString(): string
    {
        return (string) $this->result;
    }
}
