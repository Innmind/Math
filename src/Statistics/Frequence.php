<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    NumberInterface,
    Number,
    Division
};
use Innmind\Immutable\Sequence;

final class Frequence
{
    private $values;
    private $size;

    public function __construct(NumberInterface ...$values)
    {
        $this->values = new Sequence(...$values);
        $this->size = new Number($this->values->size());
    }

    public function __invoke(NumberInterface $number): NumberInterface
    {
        $frequence = $this
            ->values
            ->filter(function(NumberInterface $value) use ($number): bool {
                return $value->equals($number);
            })
            ->size();

        return new Division(new Number($frequence), $this->size);
    }

    public function size(): NumberInterface
    {
        return $this->size;
    }
}
