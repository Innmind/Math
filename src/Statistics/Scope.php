<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    NumberInterface,
    Round
};
use Innmind\Immutable\Sequence;

final class Scope implements NumberInterface
{
    private $result;

    public function __construct(
        NumberInterface $first,
        NumberInterface $second,
        NumberInterface ...$values
    ) {
        $sequence = (new Sequence($first, $second, ...$values))
            ->sort(function(NumberInterface $a, NumberInterface $b): bool {
                return $a->higherThan($b);
            });
        $this->result = $sequence->last()->subtract($sequence->first());
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

    public function add(NumberInterface $number): NumberInterface
    {
        return $this->result->add($number);
    }

    public function subtract(NumberInterface $number): NumberInterface
    {
        return $this->result->subtract($number);
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

    public function __toString(): string
    {
        return (string) $this->result;
    }
}
