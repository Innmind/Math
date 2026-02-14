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

class ArcCosineTest extends TestCase
{
    public function testInterface()
    {
        $acos = Degree::of(Number::of(42))
            ->cosine()
            ->apply(Trigonometry::arcCosine);

        $this->assertSame('cos⁻¹(cos(42°))', $acos->toString());
    }

    public function testEquals()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();

        $this->assertTrue($acos->equals(Number::of(42.0)));
        $this->assertFalse($acos->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();

        $this->assertFalse($acos->higherThan(Number::of(42.0)));
        $this->assertTrue($acos->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->add(Number::of(1));

        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->subtract(Number::of(66));

        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->divideBy(Number::of(2));

        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->multiplyBy(Number::of(2));

        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
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
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->ceil();

        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->modulo(Number::of(3));

        $this->assertSame(0, $number->value());
    }

    public function testAbsolute()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->absolute();

        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->power(Number::of(2));

        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->squareRoot();

        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $acos = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number();
        $number = $acos->exponential();

        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Radian::of(
            Degree::of(Number::of(42))
                ->cosine()
                ->apply(Trigonometry::arcCosine),
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
                ->cosine()
                ->apply(Trigonometry::arcCosine),
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
                ->cosine()
                ->apply(Trigonometry::arcCosine),
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
                ->cosine()
                ->apply(Trigonometry::arcCosine),
        )
            ->toDegree()
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
