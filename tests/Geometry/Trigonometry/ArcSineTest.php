<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcSine,
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
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
use PHPUnit\Framework\TestCase;

class ArcSineTest extends TestCase
{
    public function testInterface()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );

        $this->assertInstanceOf(Number::class, $asin);
        $this->assertInstanceOf(Degree::class, $asin->toDegree());
        $this->assertSame('sin⁻¹(sin(42°))', $asin->toString());
        $this->assertSame('42°', $asin->toDegree()->toString());
    }

    public function testEquals()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );

        $this->assertTrue($asin->equals($asin));
        $this->assertTrue($asin->equals(Real::of(42.0)));
        $this->assertFalse($asin->equals(Real::of(0.74)));
    }

    public function testHigherThan()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );

        $this->assertFalse($asin->higherThan($asin));
        $this->assertFalse($asin->higherThan(Real::of(42.0)));
        $this->assertTrue($asin->higherThan(Real::of(0.74)));
    }

    public function testAdd()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->add(Real::of(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );

        $this->assertEquals(42.0, $number->roundUp(1)->value());
        $this->assertEquals(42.0, $number->roundDown(1)->value());
        $this->assertEquals(42.0, $number->roundEven(1)->value());
        $this->assertEquals(42.0, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->modulo(Real::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $asin = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        );
        $number = $asin->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = ArcSine::of(
            Sine::of(Degree::of(Real::of(42))),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
