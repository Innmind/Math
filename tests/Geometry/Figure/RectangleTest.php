<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure\Rectangle,
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class RectangleTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Figure::class,
            Rectangle::of(
                Segment::of(Integer::of(2)),
                Segment::of(Integer::of(4)),
            ),
        );
    }

    public function testPerimeter()
    {
        $rectangle = Rectangle::of(
            Segment::of(Integer::of(2)),
            Segment::of(Integer::of(4)),
        );

        $this->assertInstanceOf(Number::class, $rectangle->perimeter());
        $this->assertSame(12, $rectangle->perimeter()->value());
    }

    public function testArea()
    {
        $rectangle = Rectangle::of(
            Segment::of(Integer::of(2)),
            Segment::of(Integer::of(4)),
        );

        $this->assertInstanceOf(Number::class, $rectangle->area());
        $this->assertSame(8, $rectangle->area()->value());
    }

    public function testLength()
    {
        $rectangle = Rectangle::of(
            $expected = Segment::of(Integer::of(2)),
            Segment::of(Integer::of(4)),
        );

        $this->assertSame($expected, $rectangle->length());
    }

    public function testWidth()
    {
        $rectangle = Rectangle::of(
            Segment::of(Integer::of(2)),
            $expected = Segment::of(Integer::of(4)),
        );

        $this->assertSame($expected, $rectangle->width());
    }
}
