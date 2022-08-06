<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Theorem;

use Innmind\Math\{
    Geometry\Theorem\AlKashi,
    Geometry\Angle\Degree,
    Geometry\Segment,
    Algebra\Integer,
    Exception\SegmentsCannotBeJoined
};
use PHPUnit\Framework\TestCase;

class AlKashiTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('C²=A²+B²-2AB*cos(A,B)', (new AlKashi)->toString());
    }

    public function testSide()
    {
        $c = AlKashi::side(
            new Segment(new Integer(5)),
            new Degree(new Integer(49)),
            new Segment(new Integer(7)),
        );

        $this->assertInstanceOf(Segment::class, $c);
        $this->assertSame(
            '√(((5^2) + (7^2)) - (((2 x 5) x 7) x cos(49°)))',
            $c->length()->toString(),
        );
        $this->assertSame(
            5.298666621959196,
            $c->length()->value(),
        );
    }

    public function testAngle()
    {
        $ab = AlKashi::angle(
            new Segment(new Integer(6)),
            new Segment(new Integer(7)),
            new Segment(new Integer(8)),
        );

        $this->assertInstanceOf(Degree::class, $ab);
        $this->assertSame(75.52248781407008, $ab->number()->value());
    }

    public function testThrowWhenOpenTriangle()
    {
        $this->expectException(SegmentsCannotBeJoined::class);

        AlKashi::angle(
            new Segment(new Integer(1)),
            new Segment(new Integer(42)),
            new Segment(new Integer(20)),
        );
    }
}
