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
            Segment::of(Integer::of(5)),
            Degree::of(Integer::of(49)),
            Segment::of(Integer::of(7)),
        );

        $this->assertInstanceOf(Segment::class, $c);
        $this->assertSame(
            '√(((5^2) + (7^2)) - (((2 x 5) x 7) x cos(49°)))',
            $c->length()->toString(),
        );
        $this->assertSame(
            5.298666621959197,
            $c->length()->value(),
        );
    }

    public function testAngle()
    {
        $ab = AlKashi::angle(
            Segment::of(Integer::of(6)),
            Segment::of(Integer::of(7)),
            Segment::of(Integer::of(8)),
        );

        $this->assertInstanceOf(Degree::class, $ab);
        $this->assertSame(75.52248781407008, $ab->number()->value());
    }

    public function testThrowWhenOpenTriangle()
    {
        $this->expectException(SegmentsCannotBeJoined::class);

        AlKashi::angle(
            Segment::of(Integer::of(1)),
            Segment::of(Integer::of(42)),
            Segment::of(Integer::of(20)),
        );
    }
}
