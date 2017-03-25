<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Addition,
    Number,
    OperationInterface,
    NumberInterface,
    Subtraction,
    Division,
    Multiplication,
    Round,
    Floor,
    Ceil
};
use PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    public function testInterface()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertInstanceOf(OperationInterface::class, $addition);
        $this->assertInstanceOf(NumberInterface::class, $addition);
    }

    public function testResult()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );
        $result = $addition->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(132, $result->value());
        $this->assertTrue($result->equals($addition->sum()));
    }

    public function testValue()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertSame(132, $addition->value());
    }

    public function testEquals()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertTrue($addition->equals(new Number(132)));
        $this->assertFalse($addition->equals(new Number(131)));
    }

    public function testHigherThan()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42),
            new Number(66)
        );

        $this->assertFalse($addition->higherThan(new Number(132)));
        $this->assertTrue($addition->higherThan(new Number(131)));
    }

    public function testAdd()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42)
        );
        $number = $addition->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testSubtract()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42)
        );
        $number = $addition->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(0, $number->value());
    }

    public function testDivideBy()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42)
        );
        $number = $addition->divideBy(new Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(22, $number->value());
    }

    public function testMulitplyBy()
    {
        $addition = new Addition(
            new Number(24),
            new Number(42)
        );
        $number = $addition->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testRound()
    {
        $addition = new Addition(
            new Number(2.1),
            new Number(4.24)
        );
        $number = $addition->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(6.3, $number->value());
    }

    public function testFloor()
    {
        $addition = new Addition(
            new Number(2.1),
            new Number(4.24)
        );
        $number = $addition->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $addition = new Addition(
            new Number(2.1),
            new Number(4.24)
        );
        $number = $addition->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testStringCast()
    {
        $addition = new Addition(
            new Number(24),
            new Addition(
                new Number(42),
                new Number(66)
            )
        );

        $this->assertSame('24 + (42 + 66)', (string) $addition);
    }

    /**
     * @expectedException Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException
     */
    public function testThrowWhenNotEnoughNumbers()
    {
        new Addition(new Number(42));
    }
}
