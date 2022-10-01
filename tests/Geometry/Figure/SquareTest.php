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
            Square::of(
                Segment::of(Integer::of(2)),
            ),
        );
    }

    public function testPerimeter()
    {
        $square = Square::of(
            Segment::of(Integer::of(2)),
        );

        $this->assertInstanceOf(Number::class, $square->perimeter());
        $this->assertSame(8, $square->perimeter()->value());
    }

    public function testArea()
    {
        $square = Square::of(
            Segment::of(Integer::of(2)),
        );

        $this->assertInstanceOf(Number::class, $square->area());
        $this->assertSame(4, $square->area()->value());
    }

    public function testSide()
    {
        $square = Square::of(
            $expected = Segment::of(Integer::of(2)),
        );

        $this->assertSame($expected, $square->side());
    }
}
