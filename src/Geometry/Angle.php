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
    public static function of(
        Segment $firstSegment,
        Degree $degree,
        Segment $secondSegment,
    ): self {
        return new self($firstSegment, $degree, $secondSegment);
    }

    public function firstSegment(): Segment
    {
        return $this->firstSegment;
    }

    public function secondSegment(): Segment
    {
        return $this->secondSegment;
    }

    public function degree(): Degree
    {
        return $this->degree;
    }

    /**
     * It sums the segments like we would sum vectors, except here we don't use
     * vectors as it would need a plan to express a direction
     */
    public function sum(): Segment
    {
        return AlKashi::side(
            $this->firstSegment,
            $this->degree,
            $this->secondSegment,
        );
    }

    public function scalarProduct(): Number
    {
        return $this
            ->firstSegment
            ->length()
            ->multiplyBy($this->secondSegment->length())
            ->multiplyBy($this->degree->cosine());
    }
}
