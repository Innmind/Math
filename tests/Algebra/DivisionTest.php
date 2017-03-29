<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Division,
    Number,
    OperationInterface,
    NumberInterface,
    Addition,
    Subtraction,
    Multiplication,
    Round,
    Floor,
    Ceil,
    Modulo
};
use PHPUnit\Framework\TestCase;

class DivisionTest extends TestCase
{
    public function testInterface()
    {
        $division = new Division(
            $dividend = new Number(4),
            $divisor = new Number(2)
        );

        $this->assertInstanceOf(OperationInterface::class, $division);
        $this->assertInstanceOf(NumberInterface::class, $division);
        $this->assertSame($dividend, $division->dividend());
        $this->assertSame($divisor, $division->divisor());
    }

    public function testResult()
    {
        $division = new Division(new Number(4), new Number(2));
        $result = $division->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2, $result->value());
        $this->assertTrue($result->equals($division->quotient()));
    }

    public function testValue()
    {
        $division = new Division(new Number(4), new Number(2));

        $this->assertSame(2, $division->value());
    }

    public function testEquals()
    {
        $division = new Division(new Number(4), new Number(2));

        $this->assertTrue($division->equals(new Number(2)));
        $this->assertFalse($division->equals(new Number(2.1)));
    }

    public function testHigherThan()
    {
        $division = new Division(new Number(4), new Number(2));

        $this->assertFalse($division->higherThan(new Number(2)));
        $this->assertTrue($division->higherThan(new Number(1.9)));
    }

    public function testAdd()
    {
        $division = new Division(new Number(4), new Number(2));
        $number = $division->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(68, $number->value());
    }

    public function testSubtract()
    {
        $division = new Division(new Number(4), new Number(2));
        $number = $division->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-64, $number->value());
    }

    public function testDivideBy()
    {
        $division = new Division(new Number(9), new Number(3));
        $number = $division->divideBy(new Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testMulitplyBy()
    {
        $division = new Division(new Number(4), new Number(2));
        $number = $division->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(4, $number->value());
    }

    public function testRound()
    {
        $division = new Division(new Number(6.66), new Number(3));
        $number = $division->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(2.2, $number->value());
    }

    public function testFloor()
    {
        $division = new Division(new Number(6.66), new Number(3));
        $number = $division->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testCeil()
    {
        $division = new Division(new Number(6.66), new Number(3));
        $number = $division->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testModulo()
    {
        $division = new Division(new Number(9), new Number(3));
        $number = $division->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '(2 + 2) ÷ 2',
            (string) new Division(
                new Addition(
                    new Number(2),
                    new Number(2)
                ),
                new Number(2)
            )
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\DivisionByZeroError
     */
    public function testThrowWhenTryingToDivideByZero()
    {
        new Division(new Number(4), new Number(0));
    }
}
