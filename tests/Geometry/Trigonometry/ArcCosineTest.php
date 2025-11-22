<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcCosine,
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ArcCosineTest extends TestCase
{
    public function testInterface()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        );

        $this->assertInstanceOf(Degree::class, $acos->toDegree());
        $this->assertSame('cos⁻¹(cos(42°))', $acos->toString());
        $this->assertSame('42°', $acos->toDegree()->toString());
    }

    public function testEquals()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();

        $this->assertTrue($acos->equals(Number::of(42.0)));
        $this->assertFalse($acos->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();

        $this->assertFalse($acos->higherThan(Number::of(42.0)));
        $this->assertTrue($acos->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->add(Number::of(1));

        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->subtract(Number::of(66));

        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->divideBy(Number::of(2));

        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->multiplyBy(Number::of(2));

        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();

        $this->assertEquals(42.0, $number->roundUp(1)->value());
        $this->assertEquals(42.0, $number->roundDown(1)->value());
        $this->assertEquals(42.0, $number->roundEven(1)->value());
        $this->assertEquals(42.0, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->ceil();

        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->modulo(Number::of(3));

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->absolute();

        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->power(Number::of(2));

        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->squareRoot();

        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        )->number();
        $number = $acos->exponential();

        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        ))
            ->number()
            ->binaryLogarithm();

        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        ))
            ->number()
            ->naturalLogarithm();

        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        ))
            ->number()
            ->commonLogarithm();

        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Number::of(42)))->number(),
        ))
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
