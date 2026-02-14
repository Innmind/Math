<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\Number;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Frequence
{
    /**
     * @param Sequence<Number> $values
     */
    private function __construct(private Sequence $values)
    {
    }

    public function __invoke(Number $number): Number
    {
        $frequence = $this
            ->values
            ->filter(static fn($value) => $value->equals($number))
            ->size();

        return Number::of($frequence)->divideBy(Number::of($this->size()));
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Number ...$values): self
    {
        return new self(Sequence::of(...$values));
    }

    /**
     * @return int<0, max>
     */
    public function size(): int
    {
        return $this->values->size();
    }
}
