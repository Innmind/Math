<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    NumberInterface,
    Number
};
use Innmind\Immutable\Sequence;

final class Mean
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
}
