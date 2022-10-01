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
        $p = Polynom::zero();

        $this->assertNotSame(
            $p,
            $p->withDegree(Integer::of(1), Integer::of(1)),
        );
    }

    public function testIntercept()
    {
        $p = Polynom::interceptAt($intercept = Integer::of(42));

        $this->assertSame($intercept, $p->intercept());
        $this->assertSame(42, $p->intercept()->value());
    }

    public function testCompute()
    {
        $p = Polynom::interceptAt(Integer::of(42))
            ->withDegree(Integer::of(1), Integer::of(2))
            ->withDegree(Integer::of(2), Integer::of(1));

        $this->assertInstanceOf(Number::class, $p(Integer::of(2)));
        $this->assertSame(50, $p(Integer::of(2))->value());
    }

    public function testOnlyOneDegreePresentInAPolynom()
    {
        $p = Polynom::interceptAt(Integer::of(42))
            ->withDegree(Integer::of(2), Integer::of(2))
            ->withDegree(Integer::of(2), Integer::of(3));

        $this->assertSame(54, $p(Integer::of(2))->value());
    }

    public function testDerived()
    {
        $polynom = Polynom::zero()
            ->withDegree(Integer::of(2), Integer::of(1));

        $this->assertInstanceOf(
            Number::class,
            $polynom->derived(Integer::of(2)),
        );
        $this->assertSame(
            4.000,
            $polynom->derived(Integer::of(2))->roundUp(3)->value(),
        );
    }

    public function testTangent()
    {
        $polynom = Polynom::zero()
            ->withDegree(Integer::of(2), Integer::of(1));

        $this->assertInstanceOf(
            Tangent::class,
            $polynom->tangent(Integer::of(2)),
        );
        $this->assertSame(
            $polynom,
            $polynom
                ->tangent(Integer::of(2))
                ->polynom(),
        );
        $this->assertSame(
            4.0,
            $polynom->tangent(Integer::of(2))(Integer::of(2))->value(),
        );
    }

    public function testStringCast()
    {
        $polynom = Polynom::interceptAt(Integer::of(42))
            ->withDegree(Integer::of(2), Integer::of(2))
            ->withDegree(Integer::of(1), Integer::of(3))
            ->withDegree(Integer::of(3), Integer::of(1));

        $this->assertSame('1x^3 + 2x^2 + 3x + 42', $polynom->toString());

        $polynom = Polynom::zero()
            ->withDegree(Integer::of(2), Integer::of(2))
            ->withDegree(Integer::of(1), Integer::of(3))
            ->withDegree(Integer::of(3), Integer::of(1));

        $this->assertSame('1x^3 + 2x^2 + 3x', $polynom->toString());
    }

    public function testPrimitive()
    {
        $polynom = Polynom::interceptAt(Integer::of(42))
            ->withDegree(Integer::of(2), Integer::of(2))
            ->withDegree(Integer::of(1), Integer::of(3))
            ->withDegree(Integer::of(3), Integer::of(1));
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
            Polynom::zero()
                ->withDegree(Integer::of(2), Integer::of(2))
                ->primitive()
                ->toString(),
        );
    }

    public function testDerivative()
    {
        $polynom = Polynom::zero()
            ->withDegree(Integer::of(1), Integer::of(4))
            ->withDegree(Integer::of(2), Integer::of(2))
            ->withDegree(Integer::of(3), Integer::of(1));
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
        $integral = Polynom::zero()
            ->withDegree(Integer::of(2), Integer::of(3))
            ->integral();

        $this->assertInstanceOf(Integral::class, $integral);
        $this->assertSame(
            '∫(3x^2)dx = [(3 ÷ (2 + 1))x^3]',
            $integral->toString(),
        );
    }
}
