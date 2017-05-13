<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure\Circle,
    Geometry\FigureInterface,
    Geometry\Segment,
    Algebra\NumberInterface,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class CircleTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            FigureInterface::class,
            new Circle(
                new Segment(new Integer(2))
            )
        );
    }

    public function testPerimeter()
    {
        $circle = new Circle(
            new Segment(new Integer(4))
        );

        $this->assertInstanceOf(NumberInterface::class, $circle->perimeter());
        $this->assertSame(25.132741228718345, $circle->perimeter()->value());
    }

    public function testArea()
    {
        $circle = new Circle(
            new Segment(new Integer(4))
        );

        $this->assertInstanceOf(NumberInterface::class, $circle->area());
        $this->assertSame(50.26548245743669, $circle->area()->value());
    }

    public function testRadius()
    {
        $circle = new Circle(
            $expected = new Segment(new Integer(4))
        );

        $this->assertSame($expected, $circle->radius());
    }

    public function testDiameter()
    {
        $circle = new Circle(
            new Segment(new Integer(4))
        );

        $this->assertInstanceOf(Segment::class, $circle->diameter());
        $this->assertSame(8, $circle->diameter()->length()->value());
    }
}
