<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    Number\E,
    NumberInterface,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm
};
use PHPUnit\Framework\TestCase;

class ETest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(NumberInterface::class, new E);
    }

    public function testStringCast()
    {
        $this->assertSame('e', (string) new E);
    }

    public function testEquals()
    {
        $this->assertTrue((new E)->equals(new Number(M_E)));
        $this->assertFalse((new E)->equals(new Number(2.718)));
    }

    public function testHigherThan()
    {
        $this->assertTrue((new E)->higherThan(new Number(2.718)));
        $this->assertFalse((new E)->higherThan(new Number(M_E)));
    }

    public function testAdd()
    {
        $number = new E;
        $number = $number->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(68.71828182845904, $number->value());
    }

    public function testSubtract()
    {
        $number = new E;
        $number = $number->subtract(new Number(2));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(0.71828182845904, $number->value());
    }

    public function testDivideBy()
    {
        $number = new E;
        $number = $number->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(M_E / 2, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = new E;
        $number = $number->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(M_E * 2, $number->value());
    }

    public function testRound()
    {
        $number = new E;
        $number = $number->round(2);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(2.72, $number->value());
    }

    public function testFloor()
    {
        $number = new E;
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testCeil()
    {
        $number = new E;
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testModulo()
    {
        $number = new E;
        $number = $number->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.71828182845904, $number->value());
    }

    public function testAbsolute()
    {
        $number = new E;
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(M_E, $number->value());
    }

    public function testPower()
    {
        $number = new E;
        $number = $number->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(exp(2), $number->value());
    }

    public function testSquareRoot()
    {
        $number = new E;
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(sqrt(M_E), $number->value());
    }

    public function testExponential()
    {
        $number = (new E)->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(M_E), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new E)->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(M_E, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new E)->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(M_E), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new E)->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(M_E), $number->value());
    }
}
