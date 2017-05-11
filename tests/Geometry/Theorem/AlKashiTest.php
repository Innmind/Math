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
            '√(((5^2) + (7^2)) - (((2 x 5) x 7) x 0.65605902899051))',
            (string) $c
        );
        $this->assertSame(
            5.298666621959197,
            $c->value()
        );
    }
}
