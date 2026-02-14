<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use function Innmind\Math\asc;
use Innmind\Math\{
    Algebra\Number,
    Exception\LogicException,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Median
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
    #[\NoDiscard]
    public static function of(Number $first, Number ...$values): self
    {
        return new self($first, ...$values);
    }

    #[\NoDiscard]
    public function result(): Number
    {
        return $this->result;
    }

    /**
     * @param Sequence<Number> $values
     */
    private function odd(Sequence $values): Number
    {
        // mathematically the index to choose is (size+1/2) but here we
        // do (size-1)/2 as the sequence indexes start at 0
        /** @var int<0, max> */
        $index = (int) (($values->size() - 1) / 2);

        return $values
            ->get($index)
            ->match(
                static fn($result) => $result,
                static fn() => throw new LogicException,
            );
    }

    /**
     * @param Sequence<Number> $values
     */
    private function even(Sequence $values): Number
    {
        // mathematically the value is mean(size/2, size/2+1) but here we
        // do mean(size/2-1, size/2) as the sequence indexes start at 0
        /** @var int<1, max> */
        $index = (int) ($values->size() / 2);

        return Mean::of(
            $values->get($index - 1)->match(
                static fn($number) => $number,
                static fn() => throw new LogicException,
            ),
            $values->get($index)->match(
                static fn($number) => $number,
                static fn() => throw new LogicException,
            ),
        )->result();
    }
}
