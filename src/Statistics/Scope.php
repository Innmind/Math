<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\NumberInterface;
use Innmind\Immutable\Sequence;

final class Scope
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
}
