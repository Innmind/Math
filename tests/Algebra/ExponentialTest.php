<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Exponential,
    Power,
    Operation,
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
    SquareRoot,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum
};
use PHPUnit\Framework\TestCase;

class ExponentialTest extends TestCase
{
    public function testInterface()
    {
        $power = new Exponential(
            $this->createMock(Number::class)
        );

        $this->assertInstanceOf(Number::class, $power);
        $this->assertInstanceOf(Operation::class, $power);
    }

    public function testResult()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $result = $power->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(8.166169912567652, $result->value());
        $this->assertSame($result, $power->result());
    }

    public function testStringCast()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );

        $this->assertSame('e^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = new Exponential(
            new Addition(
                new Number\Number(2),
                new Number\Number(2)
            )
        );

        $this->assertSame('e^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );

        $this->assertTrue($power->equals(new Number\Number(8.166169912567652)));
        $this->assertFalse($power->equals(new Number\Number(8.16)));
    }

    public function testHigherThan()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );

        $this->assertTrue($power->higherThan(new Number\Number(8.16)));
        $this->assertFalse($power->higherThan(new Number\Number(8.166169912567652)));
    }

    public function testAdd()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(74.1661699126, $number->value());
    }

    public function testSubtract()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-57.83383008743235, $number->value());
    }

    public function testDivideBy()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(4.083084956283826, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(16.332339825135303, $number->value());
    }

    public function testRound()
    {
        $number = new Exponential(
            new Number\Number(2.1)
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(8.0, $number->value());
    }

    public function testCeil()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testModulo()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->modulo(new Number\Number(8));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.1661699126, $number->value());
    }

    public function testAbsolute()
    {
        $power = new Exponential(
            new Number\Number(-2.1)
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.1224564283, $number->value());
    }

    public function testPower()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(66.68633104092517, $number->value());
    }

    public function testSquareRoot()
    {
        $power = new Exponential(
            new Number\Number(2.1)
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.8576511181, $number->value());
    }

    public function testExponential()
    {
        $number = (new Exponential(new Number\Number(0)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(1), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Exponential(new Number\Number(1)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(exp(1), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Exponential(new Number\Number(1)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(exp(1)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Exponential(new Number\Number(1)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(exp(1)), $number->value());
    }

    public function testSignum()
    {
        $number = (new Exponential(new Number\Number(1)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
