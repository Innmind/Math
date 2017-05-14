<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use function Innmind\Math\divide;
use Innmind\Math\{
    Polynom\Degree,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class DegreeTest extends TestCase
{
    public function testDegree()
    {
        $d = new Degree(new Integer(8), new Number(2));

        $this->assertSame(8, $d->degree()->value());
        $this->assertSame(2, $d->coeff()->value());
        $this->assertSame(512, $d(new Number(2))->value());
    }

    public function testStringCast()
    {
        $d = new Degree(new Integer(8), new Number(2));

        $this->assertSame('2x^8', (string) $d);

        $d = new Degree(new Integer(1), new Number(2));

        $this->assertSame('2x', (string) $d);

        $d = new Degree(new Integer(8), divide(1, 4));

        $this->assertSame('(1 ÷ 4)x^8', (string) $d);
    }

    public function testPrimitive()
    {
        $d = new Degree(new Integer(8), new Number(2));
        $primitive = $d->primitive();

        $this->assertInstanceOf(Degree::class, $primitive);
        $this->assertNotSame($d, $primitive);
        $this->assertSame('2x^8', (string) $d);
        $this->assertSame('(2 ÷ (8 + 1))x^9', (string) $primitive);
    }

    public function testDerivative()
    {
        $degree = new Degree(new Integer(2), new Integer(2));
        $derivative = $degree->derivative();

        $this->assertInstanceOf(Degree::class, $derivative);
        $this->assertNotSame($degree, $derivative);
        $this->assertSame('2x^2', (string) $degree);
        $this->assertSame('(2 x 2)x', (string) $derivative);
    }
}
