<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\NumberInterface;
use Innmind\Immutable\Sequence;

final class Median
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
                $this->result = (new Mean(
                    $sequence->get($index - 1),
                    $sequence->get($index)
                ))->result();
                break;
        }
    }

    public function result(): NumberInterface
    {
        return $this->result;
    }
}
