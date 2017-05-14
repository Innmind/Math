<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure\Triangle,
    Geometry\FigureInterface,
    Geometry\Segment,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class TriangleTest extends TestCase
{
    public function testInterface()
    {
        $triangle = new Triangle(
            new Segment(new Integer(2)),
            new Segment(new Integer(2)),
            new Segment(new Integer(2))
        );

        $this->assertInstanceOf(FigureInterface::class, $triangle);
    }

    public function testPerimeter()
    {
        $triangle = new Triangle(
            new Segment(new Integer(2)),
            new Segment(new Integer(3)),
            new Segment(new Integer(4))
        );

        $this->assertInstanceOf(NumberInterface::class, $triangle->perimeter());
        $this->assertSame(9, $triangle->perimeter()->value());
    }

    public function testArea()
    {
        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            new Segment(new Integer(24)),
            new Segment(new Integer(16))
        );

        $this->assertInstanceOf(NumberInterface::class, $triangle->area());
        $this->assertSame(54.878774585444184, $triangle->area()->value());
    }

    public function testBase()
    {
        $triangle = new Triangle(
            $expected = new Segment(new Integer(24)),
            new Segment(new Number(9.8)),
            new Segment(new Integer(16))
        );

        $this->assertSame($expected, $triangle->base());

        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            $expected = new Segment(new Integer(24)),
            new Segment(new Integer(16))
        );

        $this->assertSame($expected, $triangle->base());

        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            new Segment(new Integer(16)),
            $expected = new Segment(new Integer(24))
        );

        $this->assertSame($expected, $triangle->base());
    }

    public function testHeight()
    {
        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            new Segment(new Integer(24)),
            new Segment(new Integer(16))
        );

        $this->assertInstanceOf(Segment::class, $triangle->height());
        $this->assertSame(
            4.573231215453682,
            $triangle->height()->length()->value()
        );
    }

    public function testIsIsosceles()
    {
        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            new Segment(new Integer(16)),
            new Segment(new Integer(16))
        );

        $this->assertTrue($triangle->isIsosceles());

        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            new Segment(new Integer(15)),
            new Segment(new Integer(16))
        );

        $this->assertFalse($triangle->isIsosceles());
    }

    public function testIsEquilateral()
    {
        $triangle = new Triangle(
            new Segment(new Integer(16)),
            new Segment(new Integer(16)),
            new Segment(new Integer(16))
        );

        $this->assertTrue($triangle->isEquilateral());

        $triangle = new Triangle(
            new Segment(new Number(9.8)),
            new Segment(new Integer(16)),
            new Segment(new Integer(16))
        );

        $this->assertFalse($triangle->isEquilateral());
    }
}
