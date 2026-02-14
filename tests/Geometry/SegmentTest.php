<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Segment,
    Geometry\Angle,
    Geometry\Angle\Degree,
    Algebra\Number,
    Exception\LengthMustBePositive,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SegmentTest extends TestCase
{
    public function testLength()
    {
        $segment = Segment::of($length = Number::of(2));

        $this->assertSame($length, $segment->length());
    }

    public function testStringCast()
    {
        $this->assertSame('2', Segment::of(Number::of(2))->toString());
    }

    public function testThrowWhenNullSegment()
    {
        $this->expectException(LengthMustBePositive::class);

        Segment::of(Number::of(0));
    }

    public function testThrowWhenNegativeLength()
    {
        $this->expectException(LengthMustBePositive::class);

        Segment::of(Number::of(-1));
    }

    public function testJoin()
    {
        $first = Segment::of(Number::of(1));
        $second = Segment::of(Number::of(1));
        $degree = Degree::of(Number::of(42));

        $angle = $first->join($second, $degree);

        $this->assertInstanceOf(Angle::class, $angle);
        $this->assertSame($first, $angle->firstSegment());
        $this->assertSame($degree, $angle->degree());
        $this->assertSame($second, $angle->secondSegment());
    }
}
