<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Polynom,
    Polynom\Degree,
    Polynom\Tangent,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class PolynomTest extends TestCase
{
    public function testImmutability()
    {
        $p = new Polynom(new Number(0));

        $this->assertNotSame(
            $p,
            $p->withDegree(new Integer(1), new Integer(1))
        );
    }

    public function testDegree()
    {
        $p = (new Polynom(new Number(0)))->withDegree(
            new Integer(1),
            new Number(1)
        );

        $this->assertTrue($p->hasDegree(1));
        $this->assertFalse($p->hasDegree(2));
        $this->assertInstanceOf(Degree::class, $p->degree(1));

        $p = new Polynom(
            new Number(0),
            $d = new Degree(new Integer(1), new Number(2))
        );

        $this->assertTrue($p->hasDegree(1));
        $this->assertSame($d, $p->degree(1));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowIfTryingToAccessUnknownDegree()
    {
        $p = new Polynom(new Number(0));

        $p->degree(2);
    }

    public function testIntercept()
    {
        $p = new Polynom($intercept = new Number(42));

        $this->assertSame($intercept, $p->intercept());
        $this->assertSame(42, $p->intercept()->value());
    }

    public function testCompute()
    {
        $p = (new Polynom(new Number(42)))
            ->withDegree(new Integer(1), new Number(2))
            ->withDegree(new Integer(2), new Number(1));

        $this->assertInstanceOf(NumberInterface::class, $p(new Number(2)));
        $this->assertSame(50, $p(new Number(2))->value());
    }

    public function testOnlyOneDegreePresentInAPolynom()
    {
        $p = (new Polynom(new Number(42)))
            ->withDegree(new Integer(2), new Number(2))
            ->withDegree(new Integer(2), new Number(3));

        $this->assertSame(54, $p(new Number(2))->value());
    }

    public function testDerived()
    {
        $polynom = (new Polynom(new Number(0)))
            ->withDegree(new Integer(2), new Number(1));

        $this->assertInstanceOf(
            NumberInterface::class,
            $polynom->derived(new Number(2))
        );
        $this->assertSame(
            4.000,
            $polynom->derived(new Number(2))->round(3)->value()
        );
    }

    public function testTangent()
    {
        $polynom = (new Polynom(new Number(0)))
            ->withDegree(new Integer(2), new Number(1));

        $this->assertInstanceOf(
            Tangent::class,
            $polynom->tangent(new Number(2))
        );
        $this->assertSame(
            $polynom,
            $polynom
                ->tangent(new Number(2))
                ->polynom()
        );
        $this->assertSame(
            4.0,
            $polynom->tangent(new Number(2))(new Number(2))->value()
        );
    }

    public function testStringCast()
    {
        $polynom = (new Polynom(new Number(42)))
            ->withDegree(new Integer(2), new Number(2))
            ->withDegree(new Integer(1), new Number(3))
            ->withDegree(new Integer(3), new Number(1));

        $this->assertSame('1x^3 + 2x^2 + 3x + 42', (string) $polynom);

        $polynom = (new Polynom(new Number(0)))
            ->withDegree(new Integer(2), new Number(2))
            ->withDegree(new Integer(1), new Number(3))
            ->withDegree(new Integer(3), new Number(1));

        $this->assertSame('1x^3 + 2x^2 + 3x', (string) $polynom);
    }

    public function testPrimitive()
    {
        $polynom = (new Polynom(new Number(42)))
            ->withDegree(new Integer(2), new Number(2))
            ->withDegree(new Integer(1), new Number(3))
            ->withDegree(new Integer(3), new Number(1));
        $primitive = $polynom->primitive();

        $this->assertInstanceOf(Polynom::class, $primitive);
        $this->assertNotSame($polynom, $primitive);
        $this->assertSame('1x^3 + 2x^2 + 3x + 42', (string) $polynom);
        $this->assertSame(
            '(1 ÷ (3 + 1))x^4 + (2 ÷ (2 + 1))x^3 + (3 ÷ (1 + 1))x^2 + 42x',
            (string) $primitive
        );
    }

    public function testDerivative()
    {
        $polynom = (new Polynom(new Number(0)))
            ->withDegree(new Integer(1), new Number(4))
            ->withDegree(new Integer(2), new Number(2))
            ->withDegree(new Integer(3), new Number(1));
        $derivative = $polynom->derivative();

        $this->assertInstanceOf(Polynom::class, $derivative);
        $this->assertNotSame($polynom, $derivative);
        $this->assertSame('1x^3 + 2x^2 + 4x', (string) $polynom);
        $this->assertSame(
            '(1 x 3)x^2 + (2 x 2)x + 4',
            (string) $derivative
        );
    }
}
