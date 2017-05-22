<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Angle,
    Geometry\Angle\Degree,
    Geometry\Segment,
    Algebra\Number,
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

    public function testSum()
    {
        $angle = new Angle(
            new Segment(new Integer(5)),
            new Degree(new Integer(49)),
            new Segment(new Integer(7))
        );
        $segment = $angle->sum();

        $this->assertInstanceOf(Segment::class, $segment);
        $this->assertSame(
            5.298666621959197,
            $segment->length()->value()
        );
    }

    public function testScalarProduct()
    {
        $angle = new Angle(
            new Segment(new Integer(5)),
            new Degree(new Integer(49)),
            new Segment(new Integer(7))
        );
        $number = $angle->scalarProduct();

        $this->assertInstanceOf(Number::class, $number);
        $this->assertSame(
            22.962066014667755,
            $number->value()
        );
    }
}
