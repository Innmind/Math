<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\Geometry\Angle\Degree;

final class Angle
{
    private $firstSegment;
    private $secondSegment;
    private $degree;

    public function __construct(
        Segment $firstSegment,
        Degree $degree,
        Segment $secondSegment
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
}
