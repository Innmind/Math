<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Theorem\AlKashi,
    Algebra\Number,
};

/**
 * @psalm-immutable
 */
final class Angle
{
    private function __construct(
        private Segment $firstSegment,
        private Degree $degree,
        private Segment $secondSegment,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(
        Segment $firstSegment,
        Degree $degree,
        Segment $secondSegment,
    ): self {
        return new self($firstSegment, $degree, $secondSegment);
    }

    #[\NoDiscard]
    public function firstSegment(): Segment
    {
        return $this->firstSegment;
    }

    #[\NoDiscard]
    public function secondSegment(): Segment
    {
        return $this->secondSegment;
    }

    #[\NoDiscard]
    public function degree(): Degree
    {
        return $this->degree;
    }

    /**
     * It sums the segments like we would sum vectors, except here we don't use
     * vectors as it would need a plan to express a direction
     */
    #[\NoDiscard]
    public function sum(): Segment
    {
        return AlKashi::side(
            $this->firstSegment,
            $this->degree,
            $this->secondSegment,
        );
    }

    #[\NoDiscard]
    public function scalarProduct(): Number
    {
        return $this
            ->firstSegment
            ->length()
            ->multiplyBy($this->secondSegment->length())
            ->multiplyBy($this->degree->cosine());
    }
}
