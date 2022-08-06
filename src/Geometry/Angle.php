<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use function Innmind\Math\{
    cosine,
    multiply,
};
use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Theorem\AlKashi,
    Algebra\Number,
};

final class Angle
{
    private Segment $firstSegment;
    private Segment $secondSegment;
    private Degree $degree;

    public function __construct(
        Segment $firstSegment,
        Degree $degree,
        Segment $secondSegment,
    ) {
        $this->firstSegment = $firstSegment;
        $this->secondSegment = $secondSegment;
        $this->degree = $degree;
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
        return multiply(
            $this->firstSegment->length(),
            $this->secondSegment->length(),
            cosine($this->degree),
        );
    }
}
