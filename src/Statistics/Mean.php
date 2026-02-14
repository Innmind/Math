<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Mean
{
    private Number $result;

    private function __construct(Number $first, Number ...$values)
    {
        $sum = \array_reduce(
            $values,
            static fn(Number $a, Number $b) => $a->add($b),
            $first,
        );
        $this->result = $sum->divideBy(Number::of(
            \count($values) + 1,
        ));
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $first, Number ...$values): self
    {
        return new self($first, ...$values);
    }

    public function result(): Number
    {
        return $this->result;
    }
}
