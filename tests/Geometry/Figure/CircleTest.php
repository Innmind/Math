<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure\Circle,
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CircleTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Figure::class,
            Circle::of(
                Segment::of(Number::of(2)),
            ),
        );
    }

    public function testPerimeter()
    {
        $circle = Circle::of(
            Segment::of(Number::of(4)),
        );

        $this->assertInstanceOf(Number::class, $circle->perimeter());
        $this->assertSame(25.132741228718345, $circle->perimeter()->value());
    }

    public function testArea()
    {
        $circle = Circle::of(
            Segment::of(Number::of(4)),
        );

        $this->assertInstanceOf(Number::class, $circle->area());
        $this->assertSame(50.26548245743669, $circle->area()->value());
    }

    public function testRadius()
    {
        $circle = Circle::of(
            $expected = Segment::of(Number::of(4)),
        );

        $this->assertSame($expected, $circle->radius());
    }

    public function testDiameter()
    {
        $circle = Circle::of(
            Segment::of(Number::of(4)),
        );

        $this->assertInstanceOf(Segment::class, $circle->diameter());
        $this->assertSame(8, $circle->diameter()->length()->value());
    }
}
