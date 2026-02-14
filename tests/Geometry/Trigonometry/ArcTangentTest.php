<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
    Algebra\Logarithm,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ArcTangentTest extends TestCase
{
    public function testInterface()
    {
        $atan = Degree::of(Number::of(42))
            ->tangent()
            ->apply(Trigonometry::arcTangent);

        $this->assertSame('tan⁻¹(tan(42°))', $atan->toString());
    }

    public function testEquals()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();

        $this->assertTrue($atan->equals(Number::of(42.0)));
        $this->assertFalse($atan->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();

        $this->assertFalse($atan->higherThan(Number::of(42.0)));
        $this->assertTrue($atan->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->add(Number::of(1));

        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->subtract(Number::of(66));

        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->divideBy(Number::of(2));

        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->multiplyBy(Number::of(2));

        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();

        $this->assertEquals(42.0, $number->roundUp(1)->value());
        $this->assertEquals(42.0, $number->roundDown(1)->value());
        $this->assertEquals(42.0, $number->roundEven(1)->value());
        $this->assertEquals(42.0, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->ceil();

        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->modulo(Number::of(3));

        $this->assertSame(0, $number->value());
    }

    public function testAbsolute()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->absolute();

        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->power(Number::of(2));

        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->squareRoot();

        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $atan = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number();
        $number = $atan->exponential();

        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number()
            ->apply(Logarithm::binary);

        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number()
            ->apply(Logarithm::natural);

        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number()
            ->apply(Logarithm::common);

        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->tangent()
                ->apply(Trigonometry::arcTangent),
        )
            ->toDegree()
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
