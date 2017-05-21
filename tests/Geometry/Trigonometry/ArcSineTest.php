<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcSine,
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
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
    Algebra\Signum
};
use PHPUnit\Framework\TestCase;

class ArcSineTest extends TestCase
{
    public function testInterface()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );

        $this->assertInstanceOf(NumberInterface::class, $asin);
        $this->assertInstanceOf(Degree::class, $asin->toDegree());
        $this->assertSame('sin⁻¹(sin(42°))', (string) $asin);
        $this->assertSame('42°', (string) $asin->toDegree());
    }

    public function testEquals()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );

        $this->assertTrue($asin->equals($asin));
        $this->assertTrue($asin->equals(new Number(42.0)));
        $this->assertFalse($asin->equals(new Number(0.74)));
    }

    public function testHigherThan()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );

        $this->assertFalse($asin->higherThan($asin));
        $this->assertFalse($asin->higherThan(new Number(42.0)));
        $this->assertTrue($asin->higherThan(new Number(0.74)));
    }

    public function testAdd()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->add(new Number(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testFloor()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->modulo(new Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $asin = new ArcSine(
            new Sine(new Degree(new Number(42)))
        );
        $number = $asin->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new ArcSine(
            new Sine(new Degree(new Number(42)))
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new ArcSine(
            new Sine(new Degree(new Number(42)))
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new ArcSine(
            new Sine(new Degree(new Number(42)))
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = (new ArcSine(
            new Sine(new Degree(new Number(42)))
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
