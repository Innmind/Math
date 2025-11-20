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
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AngleTest extends TestCase
{
    public function testInterface()
    {
        $angle = Angle::of(
            $first = Segment::of(Integer::of(1)),
            $degree = Degree::of(Integer::of(42)),
            $second = Segment::of(Integer::of(1)),
        );

        $this->assertSame($first, $angle->firstSegment());
        $this->assertSame($degree, $angle->degree());
        $this->assertSame($second, $angle->secondSegment());
    }

    public function testSum()
    {
        $angle = Angle::of(
            Segment::of(Integer::of(5)),
            Degree::of(Integer::of(49)),
            Segment::of(Integer::of(7)),
        );
        $segment = $angle->sum();

        $this->assertInstanceOf(Segment::class, $segment);
        $this->assertEqualsWithDelta(
            5.29866662195919,
            $segment->length()->value(),
            0.00000000000001,
        );
    }

    public function testScalarProduct()
    {
        $angle = Angle::of(
            Segment::of(Integer::of(5)),
            Degree::of(Integer::of(49)),
            Segment::of(Integer::of(7)),
        );
        $number = $angle->scalarProduct();

        $this->assertInstanceOf(Number::class, $number);
        $this->assertEqualsWithDelta(
            22.96206601466776,
            $number->value(),
            0.00000000000001,
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
