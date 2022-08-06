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
            new Rectangle(
                new Segment(new Integer(2)),
                new Segment(new Integer(4)),
            ),
        );
    }

    public function testPerimeter()
    {
        $rectangle = new Rectangle(
            new Segment(new Integer(2)),
            new Segment(new Integer(4)),
        );

        $this->assertInstanceOf(Number::class, $rectangle->perimeter());
        $this->assertSame(12, $rectangle->perimeter()->value());
    }

    public function testArea()
    {
        $rectangle = new Rectangle(
            new Segment(new Integer(2)),
            new Segment(new Integer(4)),
        );

        $this->assertInstanceOf(Number::class, $rectangle->area());
        $this->assertSame(8, $rectangle->area()->value());
    }

    public function testLength()
    {
        $rectangle = new Rectangle(
            $expected = new Segment(new Integer(2)),
            new Segment(new Integer(4)),
        );

        $this->assertSame($expected, $rectangle->length());
    }

    public function testWidth()
    {
        $rectangle = new Rectangle(
            new Segment(new Integer(2)),
            $expected = new Segment(new Integer(4)),
        );

        $this->assertSame($expected, $rectangle->width());
    }
}
