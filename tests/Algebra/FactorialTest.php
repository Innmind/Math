<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Factorial,
    Integer,
    Number,
    NumberInterface,
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

class FactorialTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            NumberInterface::class,
            new Factorial(42)
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\NegativeFactorialException
     */
    public function testThrowWhenNegativeFactorial()
    {
        new Factorial(-1);
    }

    public function testStringCast()
    {
        $number = new Factorial(3);

        $this->assertSame(6, $number->value());
        $this->assertSame('3!', (string) $number);
    }

    public function testEquals()
    {
        $this->assertTrue((new Factorial(3))->equals(new Factorial(3)));
        $this->assertTrue((new Factorial(3))->equals(new Number(6.0)));
        $this->assertFalse((new Factorial(3))->equals(new Number(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse((new Factorial(3))->higherThan(new Factorial(3)));
        $this->assertTrue((new Factorial(3))->higherThan(new Number(1.24)));
    }

    public function testAdd()
    {
        $number = new Factorial(3);
        $number = $number->add(new Integer(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(72, $number->value());
    }

    public function testSubtract()
    {
        $number = new Factorial(3);
        $number = $number->subtract(new Integer(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-60, $number->value());
    }

    public function testDivideBy()
    {
        $number = new Factorial(3);
        $number = $number->divideBy(new Integer(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = new Factorial(3);
        $number = $number->multiplyBy(new Integer(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(12, $number->value());
    }

    public function testRound()
    {
        $number = new Factorial(3);
        $number = $number->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testFloor()
    {
        $number = new Factorial(3);
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $number = new Factorial(3);
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testModulo()
    {
        $number = new Factorial(3);
        $number = $number->modulo(new Integer(4));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $number = new Factorial(3);
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testPower()
    {
        $number = new Factorial(3);
        $number = $number->power(new Integer(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $number = new Factorial(3);
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.4494897428, $number->value());
    }

    public function testExponential()
    {
        $number = (new Factorial(4))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(24), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Factorial(4))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(24, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Factorial(4))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(24), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Factorial(4))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(24), $number->value());
    }

    /**
     * @dataProvider factorials
     */
    public function testResult($integer, $expected)
    {
        $number = new Factorial($integer);

        $this->assertInstanceOf(NumberInterface::class, $number->result());
        $this->assertSame($expected, $number->result()->value());
    }

    public function factorials(): array
    {
        return [
            [0, 1],
            [1, 1],
            [2, 2],
            [3, 6],
            [4, 24],
            [10, 3628800],
            [100, 9.332621544394418E+157],
        ];
    }
}
