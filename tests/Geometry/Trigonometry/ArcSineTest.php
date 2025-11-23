<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ArcSineTest extends TestCase
{
    public function testInterface()
    {
        $asin = Degree::of(Number::of(42))
            ->sine()
            ->apply(Trigonometry::arcSine);

        $this->assertInstanceOf(Degree::class, $asin->toDegree());
        $this->assertSame('sin⁻¹(sin(42°))', $asin->toString());
        $this->assertSame('42°', $asin->toDegree()->toString());
    }

    public function testEquals()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();

        $this->assertTrue($asin->equals(Number::of(42.0)));
        $this->assertFalse($asin->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();

        $this->assertFalse($asin->higherThan(Number::of(42.0)));
        $this->assertTrue($asin->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->add(Number::of(1));

        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->subtract(Number::of(66));

        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->divideBy(Number::of(2));

        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->multiplyBy(Number::of(2));

        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
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
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->ceil();

        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->modulo(Number::of(3));

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->absolute();

        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->power(Number::of(2));

        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->squareRoot();

        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $asin = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number();
        $number = $asin->exponential();

        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number()
            ->binaryLogarithm();

        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number()
            ->naturalLogarithm();

        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number()
            ->commonLogarithm();

        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->sine()
                ->apply(Trigonometry::arcSine),
        )
            ->toDegree()
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
