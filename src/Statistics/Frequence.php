<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use Innmind\Math\Algebra\{
    Number,
    Division,
    Real,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Frequence
{
    /** @var Sequence<Number> */
    private Sequence $values;
    private Number $size;

    /**
     * @no-named-arguments
     */
    private function __construct(Number ...$values)
    {
        $this->values = Sequence::of(...$values);
        $this->size = Real::of($this->values->size());
    }

    public function __invoke(Number $number): Number
    {
        $frequence = $this
            ->values
            ->filter(static function(Number $value) use ($number): bool {
                return $value->equals($number);
            })
            ->size();

        return Division::of(Real::of($frequence), $this->size);
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Number ...$values): self
    {
        return new self(...$values);
    }

    public function size(): Number
    {
        return $this->size;
    }
}
