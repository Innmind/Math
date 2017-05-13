<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Exponential,
    Power,
    NumberInterface,
    OperationInterface,
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
    SquareRoot
};
use PHPUnit\Framework\TestCase;

class ExponentialTest extends TestCase
{
    public function testInterface()
    {
        $power = new Exponential(
            $this->createMock(NumberInterface::class)
        );

        $this->assertInstanceOf(NumberInterface::class, $power);
        $this->assertInstanceOf(OperationInterface::class, $power);
    }

    public function testResult()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $result = $power->result();

        $this->assertInstanceOf(NumberInterface::class, $result);
        $this->assertSame(8.166169912567652, $result->value());
        $this->assertSame($result, $power->result());
    }

    public function testStringCast()
    {
        $power = new Exponential(
            new Number(2.1)
        );

        $this->assertSame('e^2.1', (string) $power);
    }

    public function testStringCastOperations()
    {
        $power = new Exponential(
            new Addition(
                new Number(2),
                new Number(2)
            )
        );

        $this->assertSame('e^(2 + 2)', (string) $power);
    }

    public function testEquals()
    {
        $power = new Exponential(
            new Number(2.1)
        );

        $this->assertTrue($power->equals(new Number(8.166169912567652)));
        $this->assertFalse($power->equals(new Number(8.16)));
    }

    public function testHigherThan()
    {
        $power = new Exponential(
            new Number(2.1)
        );

        $this->assertTrue($power->higherThan(new Number(8.16)));
        $this->assertFalse($power->higherThan(new Number(8.166169912567652)));
    }

    public function testAdd()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(74.1661699126, $number->value());
    }

    public function testSubtract()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-57.83383008743235, $number->value());
    }

    public function testDivideBy()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(4.083084956283826, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(16.332339825135303, $number->value());
    }

    public function testRound()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(8.2, $number->value());
    }

    public function testFloor()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(8.0, $number->value());
    }

    public function testCeil()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testModulo()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->modulo(new Number(8));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.1661699126, $number->value());
    }

    public function testAbsolute()
    {
        $power = new Exponential(
            new Number(-2.1)
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.1224564283, $number->value());
    }

    public function testPower()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(66.68633104092517, $number->value());
    }

    public function testSquareRoot()
    {
        $power = new Exponential(
            new Number(2.1)
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.8576511181, $number->value());
    }

    public function testExponential()
    {
        $number = (new Exponential(new Number(0)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(1), $number->value());
    }
}
