<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Subtraction,
    Number,
    OperationInterface,
    NumberInterface,
    Addition,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute
};
use PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
{
    public function testInterface()
    {
        $subtraction = new Subtraction(
            new Number(4),
            new Number(2)
        );

        $this->assertInstanceOf(OperationInterface::class, $subtraction);
        $this->assertInstanceOf(NumberInterface::class, $subtraction);
    }

    public function testResult()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );
        $result = $subtraction->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(18, $result->value());
        $this->assertTrue($result->equals($subtraction->difference()));
    }

    public function testValue()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );

        $this->assertSame(18, $subtraction->value());
    }

    public function testEquals()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );

        $this->assertTrue($subtraction->equals(new Number(18)));
        $this->assertFalse($subtraction->equals(new Number(18.1)));
    }

    public function testHigherThan()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );

        $this->assertFalse($subtraction->higherThan(new Number(18)));
        $this->assertTrue($subtraction->higherThan(new Number(17.9)));
    }

    public function testAdd()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );
        $number = $subtraction->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testSubtract()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );
        $number = $subtraction->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-48, $number->value());
    }

    public function testDivideBy()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );
        $number = $subtraction->divideBy(new Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testMulitplyBy()
    {
        $subtraction = new Subtraction(
            new Number(42),
            new Number(24)
        );
        $number = $subtraction->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testRound()
    {
        $subtraction = new Subtraction(
            new Number(24.55),
            new Number(12.33)
        );
        $number = $subtraction->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(12.2, $number->value());
    }

    public function testFloor()
    {
        $subtraction = new Subtraction(
            new Number(24.55),
            new Number(12.33)
        );
        $number = $subtraction->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(12.0, $number->value());
    }

    public function testCeil()
    {
        $subtraction = new Subtraction(
            new Number(24.55),
            new Number(12.33)
        );
        $number = $subtraction->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(13.0, $number->value());
    }

    public function testModulo()
    {
        $subtraction = new Subtraction(
            new Number(25),
            new Number(12)
        );
        $number = $subtraction->modulo(new Number(6));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $subtraction = new Subtraction(
            new Number(12),
            new Number(25)
        );
        $number = $subtraction->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(13, $number->value());
    }

    public function testStringCast()
    {
        $subtraction = new Subtraction(
            new Addition(
                new Number(12),
                new Number(12)
            ),
            new Number(42),
            new Number(66)
        );

        $this->assertSame('(12 + 12) - 42 - 66', (string) $subtraction);
    }
}
