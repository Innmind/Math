<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcTangent,
    Geometry\Trigonometry\Tangent,
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Floor,
    Algebra\Ceil,
    Algebra\Modulo,
    Algebra\Absolute,
    Algebra\Power,
    Algebra\SquareRoot,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    Algebra\Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ArcTangentTest extends TestCase
{
    public function testInterface()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );

        $this->assertInstanceOf(Number::class, $atan);
        $this->assertInstanceOf(Degree::class, $atan->toDegree());
        $this->assertSame('tan⁻¹(tan(42°))', $atan->toString());
        $this->assertSame('42°', $atan->toDegree()->toString());
    }

    public function testEquals()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );

        $this->assertTrue($atan->equals($atan));
        $this->assertTrue($atan->equals(Real::of(42.0)));
        $this->assertFalse($atan->equals(Real::of(0.74)));
    }

    public function testHigherThan()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );

        $this->assertFalse($atan->higherThan($atan));
        $this->assertFalse($atan->higherThan(Real::of(42.0)));
        $this->assertTrue($atan->higherThan(Real::of(0.74)));
    }

    public function testAdd()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->add(Real::of(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );

        $this->assertEquals(42.0, $number->roundUp(1)->value());
        $this->assertEquals(42.0, $number->roundDown(1)->value());
        $this->assertEquals(42.0, $number->roundEven(1)->value());
        $this->assertEquals(42.0, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->modulo(Real::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $atan = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        );
        $number = $atan->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = ArcTangent::of(
            Tangent::of(Degree::of(Real::of(42))),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
