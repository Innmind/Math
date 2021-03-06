<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure\Square,
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class SquareTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Figure::class,
            new Square(
                new Segment(new Integer(2))
            )
        );
    }

    public function testPerimeter()
    {
        $square = new Square(
            new Segment(new Integer(2))
        );

        $this->assertInstanceOf(Number::class, $square->perimeter());
        $this->assertSame(8, $square->perimeter()->value());
    }

    public function testArea()
    {
        $square = new Square(
            new Segment(new Integer(2))
        );

        $this->assertInstanceOf(Number::class, $square->area());
        $this->assertSame(4, $square->area()->value());
    }

    public function testSide()
    {
        $square = new Square(
            $expected = new Segment(new Integer(2))
        );

        $this->assertSame($expected, $square->side());
    }
}
