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
    /** @var Sequence<Number> */
    private Sequence $values;

    /**
     * @no-named-arguments
     */
    private function __construct(Number ...$values)
    {
        $this->values = Sequence::of(...$values);
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
        return new self(...$values);
    }

    /**
     * @return int<0, max>
     */
    public function size(): int
    {
        return $this->values->size();
    }
}
