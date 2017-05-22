<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\Algebra\Number;

interface Figure
{
    public function perimeter(): Number;
    public function area(): Number;
}
