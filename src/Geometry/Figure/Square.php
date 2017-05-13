<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\multiply;
use Innmind\Math\{
    Geometry\FigureInterface,
    Geometry\Segment,
    Algebra\NumberInterface
};

final class Square implements FigureInterface
{
    private $side;

    public function __construct(Segment $side)
    {
        $this->side = $side;
    }

    public function perimeter(): NumberInterface
    {
        return multiply($this->side->length(), 4);
    }

    public function area(): NumberInterface
    {
        return multiply($this->side->length(), $this->side->length());
    }

    public function side(): Segment
    {
        return $this->side;
    }
}
