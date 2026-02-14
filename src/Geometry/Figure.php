<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
interface Figure
{
    #[\NoDiscard]
    public function perimeter(): Number;
    #[\NoDiscard]
    public function area(): Number;
}
