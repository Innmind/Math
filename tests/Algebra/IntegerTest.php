<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Integer,
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
    Factorial,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum
};
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Number::class,
            new Integer(42)
        );
    }

    public function testInt()
    {
        $number = new Integer(42);

        $this->assertSame(42, $number->value());
        $this->assertSame('42', (string) $number);
    }

    public function testEquals()
    {
        $this->assertTrue((new Integer(42))->equals(new Integer(42)));
        $this->assertTrue((new Integer(42))->equals(new Number\Number(42.0)));
        $this->assertFalse((new Integer(42))->equals(new Number\Number(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse((new Integer(42))->higherThan(new Integer(42)));
        $this->assertTrue((new Integer(42))->higherThan(new Number\Number(41.24)));
    }

    public function testAdd()
    {
        $number = new Integer(42);
        $number = $number->add(new Integer(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(108, $number->value());
    }

    public function testSubtract()
    {
        $number = new Integer(42);
        $number = $number->subtract(new Integer(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24, $number->value());
    }

    public function testDivideBy()
    {
        $number = new Integer(42);
        $number = $number->divideBy(new Integer(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = new Integer(42);
        $number = $number->multiplyBy(new Integer(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testRound()
    {
        $number = new Integer(42);
        $number = $number->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testFloor()
    {
        $number = new Integer(42);
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $number = new Integer(42);
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $number = new Integer(3);
        $number = $number->modulo(new Integer(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $number = new Integer(-9);
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $number = new Integer(-9);
        $number = $number->power(new Integer(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $number = new Integer(4);
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testFactorial()
    {
        $number = new Integer(3);

        $this->assertInstanceOf(Factorial::class, $number->factorial());
        $this->assertSame('3!', (string) $number->factorial());
    }

    public function testExponential()
    {
        $number = (new Integer(4))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Integer(4))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Integer(4))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Integer(4))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Integer(4))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\FactorialMustBePositive
     */
    public function testThrowWhenNegativeFactorial()
    {
        (new Integer(-1))->factorial();
    }
}
