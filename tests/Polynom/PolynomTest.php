<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Polynom,
    Polynom\Degree,
    Polynom\Tangent,
    Polynom\Integral,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class PolynomTest extends TestCase
{
    public function testImmutability()
    {
        $p = new Polynom;

        $this->assertNotSame(
            $p,
            $p->withDegree(new Integer(1), new Integer(1)),
        );
    }

    public function testDegree()
    {
        $p = (new Polynom(new Integer(0)))->withDegree(
            new Integer(1),
            new Integer(1),
        );

        $this->assertTrue($p->hasDegree(1));
        $this->assertFalse($p->hasDegree(2));
        $this->assertInstanceOf(Degree::class, $p->degree(1));

        $p = new Polynom(
            null,
            $d = new Degree(new Integer(1), new Integer(2)),
        );

        $this->assertTrue($p->hasDegree(1));
        $this->assertSame($d, $p->degree(1));
    }

    public function testThrowIfTryingToAccessUnknownDegree()
    {
        $p = new Polynom;

        $this->expectException(\LogicException::class);

        $p->degree(2);
    }

    public function testIntercept()
    {
        $p = new Polynom($intercept = new Integer(42));

        $this->assertSame($intercept, $p->intercept());
        $this->assertSame(42, $p->intercept()->value());
    }

    public function testCompute()
    {
        $p = (new Polynom(new Integer(42)))
            ->withDegree(new Integer(1), new Integer(2))
            ->withDegree(new Integer(2), new Integer(1));

        $this->assertInstanceOf(Number::class, $p(new Integer(2)));
        $this->assertSame(50, $p(new Integer(2))->value());
    }

    public function testOnlyOneDegreePresentInAPolynom()
    {
        $p = (new Polynom(new Integer(42)))
            ->withDegree(new Integer(2), new Integer(2))
            ->withDegree(new Integer(2), new Integer(3));

        $this->assertSame(54, $p(new Integer(2))->value());
    }

    public function testDerived()
    {
        $polynom = (new Polynom)
            ->withDegree(new Integer(2), new Integer(1));

        $this->assertInstanceOf(
            Number::class,
            $polynom->derived(new Integer(2)),
        );
        $this->assertSame(
            4.000,
            $polynom->derived(new Integer(2))->roundUp(3)->value(),
        );
    }

    public function testTangent()
    {
        $polynom = (new Polynom)
            ->withDegree(new Integer(2), new Integer(1));

        $this->assertInstanceOf(
            Tangent::class,
            $polynom->tangent(new Integer(2)),
        );
        $this->assertSame(
            $polynom,
            $polynom
                ->tangent(new Integer(2))
                ->polynom(),
        );
        $this->assertSame(
            4.0,
            $polynom->tangent(new Integer(2))(new Integer(2))->value(),
        );
    }

    public function testStringCast()
    {
        $polynom = (new Polynom(new Integer(42)))
            ->withDegree(new Integer(2), new Integer(2))
            ->withDegree(new Integer(1), new Integer(3))
            ->withDegree(new Integer(3), new Integer(1));

        $this->assertSame('1x^3 + 2x^2 + 3x + 42', $polynom->toString());

        $polynom = (new Polynom)
            ->withDegree(new Integer(2), new Integer(2))
            ->withDegree(new Integer(1), new Integer(3))
            ->withDegree(new Integer(3), new Integer(1));

        $this->assertSame('1x^3 + 2x^2 + 3x', $polynom->toString());
    }

    public function testPrimitive()
    {
        $polynom = (new Polynom(new Integer(42)))
            ->withDegree(new Integer(2), new Integer(2))
            ->withDegree(new Integer(1), new Integer(3))
            ->withDegree(new Integer(3), new Integer(1));
        $primitive = $polynom->primitive();

        $this->assertInstanceOf(Polynom::class, $primitive);
        $this->assertNotSame($polynom, $primitive);
        $this->assertSame('1x^3 + 2x^2 + 3x + 42', $polynom->toString());
        $this->assertSame(
            '(1 ÷ (3 + 1))x^4 + (2 ÷ (2 + 1))x^3 + (3 ÷ (1 + 1))x^2 + 42x',
            $primitive->toString(),
        );
    }

    public function testRemovePrimitiveFirstDegreeWhenNulCoefficient()
    {
        $this->assertSame(
            '(2 ÷ (2 + 1))x^3',
            (new Polynom)
                ->withDegree(new Integer(2), new Integer(2))
                ->primitive()
                ->toString(),
        );
    }

    public function testDerivative()
    {
        $polynom = (new Polynom)
            ->withDegree(new Integer(1), new Integer(4))
            ->withDegree(new Integer(2), new Integer(2))
            ->withDegree(new Integer(3), new Integer(1));
        $derivative = $polynom->derivative();

        $this->assertInstanceOf(Polynom::class, $derivative);
        $this->assertNotSame($polynom, $derivative);
        $this->assertSame('1x^3 + 2x^2 + 4x', $polynom->toString());
        $this->assertSame(
            '(1 x 3)x^2 + (2 x 2)x + 4',
            $derivative->toString(),
        );
    }

    public function testIntegral()
    {
        $integral = (new Polynom)
            ->withDegree(new Integer(2), new Integer(3))
            ->integral();

        $this->assertInstanceOf(Integral::class, $integral);
        $this->assertSame(
            '∫(3x^2)dx = [(3 ÷ (2 + 1))x^3]',
            $integral->toString(),
        );
    }
}
