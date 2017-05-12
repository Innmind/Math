<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\Algebra\NumberInterface;

interface FigureInterface
{
    public function perimeter(): NumberInterface;
    public function area(): NumberInterface;
}
