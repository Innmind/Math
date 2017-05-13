<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Theorem;

use Innmind\Math\{
    Geometry\Theorem\AlKashi,
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class AlKashiTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('C²=A²+B²-2AB*cos(A,B)', (string) new AlKashi);
    }

    public function testSide()
    {
        $c = AlKashi::side(
            new Integer(5),
            new Degree(new Integer(49)),
            new Integer(7)
        );

        $this->assertInstanceOf(NumberInterface::class, $c);
        $this->assertSame(
            '√(((5^2) + (7^2)) - (((2 x 5) x 7) x 0.6560590289905075))',
            (string) $c
        );
        $this->assertSame(
            5.298666621959197,
            $c->value()
        );
    }

    public function testAngle()
    {
        $ab = AlKashi::angle(
            new Integer(6),
            new Integer(7),
            new Integer(8)
        );

        $this->assertInstanceOf(Degree::class, $ab);
        $this->assertSame(75.52248781407008, $ab->number()->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\OpenFigureException
     */
    public function testThrowWhenOpenTriangle()
    {
        AlKashi::angle(
            new Integer(1),
            new Integer(42),
            new Integer(20)
        );
    }
}
