<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Angle,
    Geometry\Angle\Degree,
    Geometry\Segment,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class AngleTest extends TestCase
{
    public function testInterface()
    {
        $angle = new Angle(
            $first = new Segment(new Integer(1)),
            $degree = new Degree(new Integer(42)),
            $second = new Segment(new Integer(1))
        );

        $this->assertSame($first, $angle->firstSegment());
        $this->assertSame($degree, $angle->degree());
        $this->assertSame($second, $angle->secondSegment());
    }
}
