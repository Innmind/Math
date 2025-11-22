<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Polynom,
    Polynom\Tangent,
    Polynom\Integral,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PolynomTest extends TestCase
{
    public function testImmutability()
    {
        $p = Polynom::zero();

        $this->assertNotSame(
            $p,
            $p->withDegree(1, Number::of(1)),
        );
    }

    public function testIntercept()
    {
        $p = Polynom::interceptAt($intercept = Number::of(42));

        $this->assertSame($intercept, $p->intercept());
        $this->assertSame(42, $p->intercept()->value());
    }

    public function testCompute()
    {
        $p = Polynom::interceptAt(Number::of(42))
            ->withDegree(1, Number::of(2))
            ->withDegree(2, Number::of(1));

        $this->assertInstanceOf(Number::class, $p(Number::of(2)));
        $this->assertSame(50, $p(Number::of(2))->value());
    }

    public function testOnlyOneDegreePresentInAPolynom()
    {
        $p = Polynom::interceptAt(Number::of(42))
            ->withDegree(2, Number::of(2))
            ->withDegree(2, Number::of(3));

        $this->assertSame(54, $p(Number::of(2))->value());
    }

    public function testDerived()
    {
        $polynom = Polynom::zero()
            ->withDegree(2, Number::of(1));

        $this->assertInstanceOf(
            Number::class,
            $polynom->derived(Number::of(2)),
        );
        $this->assertSame(
            4.000,
            $polynom->derived(Number::of(2))->roundUp(3)->value(),
        );
    }

    public function testTangent()
    {
        $polynom = Polynom::zero()
            ->withDegree(2, Number::of(1));

        $this->assertInstanceOf(
            Tangent::class,
            $polynom->tangent(Number::of(2)),
        );
        $this->assertSame(
            $polynom,
            $polynom
                ->tangent(Number::of(2))
                ->polynom(),
        );
        $this->assertSame(
            4.0,
            $polynom->tangent(Number::of(2))(Number::of(2))->value(),
        );
    }

    public function testStringCast()
    {
        $polynom = Polynom::interceptAt(Number::of(42))
            ->withDegree(2, Number::of(2))
            ->withDegree(1, Number::of(3))
            ->withDegree(3, Number::of(1));

        $this->assertSame('1x^3 + 2x^2 + 3x + 42', $polynom->toString());

        $polynom = Polynom::zero()
            ->withDegree(2, Number::of(2))
            ->withDegree(1, Number::of(3))
            ->withDegree(3, Number::of(1));

        $this->assertSame('1x^3 + 2x^2 + 3x', $polynom->toString());
    }

    public function testPrimitive()
    {
        $polynom = Polynom::interceptAt(Number::of(42))
            ->withDegree(2, Number::of(2))
            ->withDegree(1, Number::of(3))
            ->withDegree(3, Number::of(1));
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
                ->withDegree(2, Number::of(2))
                ->primitive()
                ->toString(),
        );
    }

    public function testDerivative()
    {
        $polynom = Polynom::zero()
            ->withDegree(1, Number::of(4))
            ->withDegree(2, Number::of(2))
            ->withDegree(3, Number::of(1));
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
            ->withDegree(2, Number::of(3))
            ->integral();

        $this->assertInstanceOf(Integral::class, $integral);
        $this->assertSame(
            '∫(3x^2)dx = [(3 ÷ (2 + 1))x^3]',
            $integral->toString(),
        );
    }
}
