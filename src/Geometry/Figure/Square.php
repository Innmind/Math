<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
};

/**
 * @psalm-immutable
 */
final class Square implements Figure
{
    private function __construct(private Segment $side)
    {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Segment $side): self
    {
        return new self($side);
    }

    #[\Override]
    public function perimeter(): Number
    {
        return $this->side->length()->multiplyBy(Number::of(4));
    }

    #[\Override]
    public function area(): Number
    {
        return $this->side->length()->multiplyBy($this->side->length());
    }

    #[\NoDiscard]
    public function side(): Segment
    {
        return $this->side;
    }
}
