<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\multiply;
use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Number\Pi,
};

final class Circle implements Figure
{
    private Segment $radius;
    private Segment $diameter;

    public function __construct(Segment $radius)
    {
        $this->radius = $radius;
        $this->diameter = new Segment(
            multiply(2, $radius->length()),
        );
    }

    public function perimeter(): Number
    {
        return multiply(2, new Pi, $this->radius->length());
    }

    public function area(): Number
    {
        return multiply(
            $this->radius->length(),
            $this->radius->length(),
            new Pi,
        );
    }

    public function radius(): Segment
    {
        return $this->radius;
    }

    public function diameter(): Segment
    {
        return $this->diameter;
    }
}
