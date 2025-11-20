<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Integer,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Frequence
{
    /** @var Sequence<Number> */
    private Sequence $values;
    private Integer $size;

    /**
     * @no-named-arguments
     */
    private function __construct(Number ...$values)
    {
        $this->values = Sequence::of(...$values);
        $this->size = Integer::of($this->values->size());
    }

    public function __invoke(Number $number): Number
    {
        $frequence = $this
            ->values
            ->filter(static fn($value) => $value->equals($number))
            ->size();

        return Integer::of($frequence)->divideBy($this->size);
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Number ...$values): self
    {
        return new self(...$values);
    }

    public function size(): Integer
    {
        return $this->size;
    }
}
