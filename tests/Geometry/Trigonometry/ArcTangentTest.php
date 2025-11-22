<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcTangent,
    Geometry\Trigonometry\Tangent,
    Geometry\Angle\Degree,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ArcTangentTest extends TestCase
{
    public function testInterface()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        );

        $this->assertInstanceOf(Degree::class, $atan->toDegree());
        $this->assertSame('tan⁻¹(tan(42°))', $atan->toString());
        $this->assertSame('42°', $atan->toDegree()->toString());
    }

    public function testEquals()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();

        $this->assertTrue($atan->equals(Number::of(42.0)));
        $this->assertFalse($atan->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();

        $this->assertFalse($atan->higherThan(Number::of(42.0)));
        $this->assertTrue($atan->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->add(Number::of(1));

        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->subtract(Number::of(66));

        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->divideBy(Number::of(2));

        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->multiplyBy(Number::of(2));

        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();

        $this->assertEquals(42.0, $number->roundUp(1)->value());
        $this->assertEquals(42.0, $number->roundDown(1)->value());
        $this->assertEquals(42.0, $number->roundEven(1)->value());
        $this->assertEquals(42.0, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->ceil();

        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->modulo(Number::of(3));

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->absolute();

        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->power(Number::of(2));

        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->squareRoot();

        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $atan->exponential();

        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )
            ->number()
            ->binaryLogarithm();

        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )
            ->number()
            ->naturalLogarithm();

        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )
            ->number()
            ->commonLogarithm();

        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Number::of(42)))->number(),
        )
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
