<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\{
    add,
    multiply
};
use Innmind\Math\{
    Geometry\FigureInterface,
    Geometry\Segment,
    Algebra\NumberInterface
};

final class Rectangle implements FigureInterface
{
    private $length;
    private $width;

    public function __construct(Segment $length, Segment $width)
    {
        $this->length = $length;
        $this->width = $width;
    }

    public function perimeter(): NumberInterface
    {
        return add(
            multiply($this->length->length(), 2),
            multiply($this->width->length(), 2)
        );
    }

    public function area(): NumberInterface
    {
        return multiply(
            $this->length->length(),
            $this->width->length()
        );
    }

    public function length(): Segment
    {
        return $this->length;
    }

    public function width(): Segment
    {
        return $this->width;
    }
}
