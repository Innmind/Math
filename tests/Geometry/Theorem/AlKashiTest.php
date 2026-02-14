<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Theorem;

use Innmind\Math\{
    Geometry\Theorem\AlKashi,
    Geometry\Angle\Degree,
    Geometry\Segment,
    Algebra\Number,
    Exception\SegmentsCannotBeJoined,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AlKashiTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('C²=A²+B²-2AB*cos(A,B)', (new AlKashi)->toString());
    }

    public function testSide()
    {
        $c = AlKashi::side(
            Segment::of(Number::of(5)),
            Degree::of(Number::of(49)),
            Segment::of(Number::of(7)),
        );

        $this->assertInstanceOf(Segment::class, $c);
        $this->assertSame(
            '√(((5^2) + (7^2)) - (2 x 5 x 7 x cos(49°)))',
            $c->length()->toString(),
        );
        $this->assertEqualsWithDelta(
            5.29866662195919,
            $c->length()->value(),
            0.00000000000001,
        );
    }

    public function testAngle()
    {
        $ab = AlKashi::angle(
            Segment::of(Number::of(6)),
            Segment::of(Number::of(7)),
            Segment::of(Number::of(8)),
        );

        $this->assertInstanceOf(Degree::class, $ab);
        $this->assertSame(75.52248781407008, $ab->number()->value());
    }

    public function testThrowWhenOpenTriangle()
    {
        $this->expectException(SegmentsCannotBeJoined::class);

        $_ = AlKashi::angle(
            Segment::of(Number::of(1)),
            Segment::of(Number::of(42)),
            Segment::of(Number::of(20)),
        );
    }

    private function assertEqualsWithDelta(
        int|float $expected,
        int|float $value,
        int|float $delta,
    ): void {
        $this->assertGreaterThanOrEqual($expected-$delta, $value);
        $this->assertLessThanOrEqual($expected+$delta, $value);
    }
}
