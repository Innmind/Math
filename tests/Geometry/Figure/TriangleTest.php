<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure\Triangle,
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class TriangleTest extends TestCase
{
    public function testInterface()
    {
        $triangle = Triangle::of(
            Segment::of(Number::of(2)),
            Segment::of(Number::of(2)),
            Segment::of(Number::of(2)),
        );

        $this->assertInstanceOf(Figure::class, $triangle);
    }

    public function testPerimeter()
    {
        $triangle = Triangle::of(
            Segment::of(Number::of(2)),
            Segment::of(Number::of(3)),
            Segment::of(Number::of(4)),
        );

        $this->assertInstanceOf(Number::class, $triangle->perimeter());
        $this->assertSame(9, $triangle->perimeter()->value());
    }

    public function testArea()
    {
        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(24)),
            Segment::of(Number::of(16)),
        );

        $this->assertInstanceOf(Number::class, $triangle->area());
        $this->assertSame(54.878774585444184, $triangle->area()->value());
    }

    public function testBase()
    {
        $triangle = Triangle::of(
            $expected = Segment::of(Number::of(24)),
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(16)),
        );

        $this->assertSame($expected, $triangle->base());

        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            $expected = Segment::of(Number::of(24)),
            Segment::of(Number::of(16)),
        );

        $this->assertSame($expected, $triangle->base());

        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(16)),
            $expected = Segment::of(Number::of(24)),
        );

        $this->assertSame($expected, $triangle->base());
    }

    public function testHeight()
    {
        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(24)),
            Segment::of(Number::of(16)),
        );

        $this->assertInstanceOf(Segment::class, $triangle->height());
        $this->assertSame(
            4.573231215453682,
            $triangle->height()->length()->value(),
        );
    }

    public function testIsIsosceles()
    {
        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(16)),
            Segment::of(Number::of(16)),
        );

        $this->assertTrue($triangle->isosceles());

        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(15)),
            Segment::of(Number::of(16)),
        );

        $this->assertFalse($triangle->isosceles());
    }

    public function testIsEquilateral()
    {
        $triangle = Triangle::of(
            Segment::of(Number::of(16)),
            Segment::of(Number::of(16)),
            Segment::of(Number::of(16)),
        );

        $this->assertTrue($triangle->equilateral());

        $triangle = Triangle::of(
            Segment::of(Number::of(9.8)),
            Segment::of(Number::of(16)),
            Segment::of(Number::of(16)),
        );

        $this->assertFalse($triangle->equilateral());
    }
}
