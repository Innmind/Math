<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    NumberInterface,
    Round
};
use Innmind\Immutable\Sequence;

final class Median implements NumberInterface
{
    private $result;

    public function __construct(
        NumberInterface $first,
        NumberInterface ...$values
    ) {
        $sequence = (new Sequence($first, ...$values))
            ->sort(function(NumberInterface $a, NumberInterface $b): bool {
                return $a->higherThan($b);
            });
        switch ($sequence->size() % 2) {
            case 1:
                //mathematically the index to choose is (size+1/2) but here we
                //do (size-1)/2 as the sequence indexes start at 0
                $this->result = $sequence->get(
                    ($sequence->size() - 1) / 2
                );
                break;

            default:
                //mathematically the value is mean(size/2, size/2+1) but here we
                //do mean(size/2-1, size/2) as the sequence indexes start at 0
                $index = $sequence->size() / 2;
                $this->result = new Mean(
                    $sequence->get($index - 1),
                    $sequence->get($index)
                );
                break;
        }
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

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->result->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->result->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->result->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->result->multiplyBy($number, ...$numbers);
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

    public function exponential(): NumberInterface
    {
        return $this->result->exponential();
    }

    public function __toString(): string
    {
        return (string) $this->result;
    }
}
