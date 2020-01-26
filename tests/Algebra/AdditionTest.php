<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Addition,
    Operation,
    Number,
    Subtraction,
    Division,
    Multiplication,
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
    CommonLogarithm,
    Signum
};
use PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    public function testInterface()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42),
            new Number\Number(66)
        );

        $this->assertInstanceOf(Operation::class, $addition);
        $this->assertInstanceOf(Number::class, $addition);
        $this->assertSame('24 + 42 + 66', $addition->toString());
    }

    public function testResult()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42),
            new Number\Number(66)
        );
        $result = $addition->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(132, $result->value());
        $this->assertTrue($result->equals($addition->sum()));
        $this->assertSame($result, $addition->result());
    }

    public function testValue()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42),
            new Number\Number(66)
        );

        $this->assertSame(132, $addition->value());
    }

    public function testEquals()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42),
            new Number\Number(66)
        );

        $this->assertTrue($addition->equals(new Number\Number(132)));
        $this->assertFalse($addition->equals(new Number\Number(131)));
    }

    public function testHigherThan()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42),
            new Number\Number(66)
        );

        $this->assertFalse($addition->higherThan(new Number\Number(132)));
        $this->assertTrue($addition->higherThan(new Number\Number(131)));
    }

    public function testAdd()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42)
        );
        $number = $addition->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testSubtract()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42)
        );
        $number = $addition->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(0, $number->value());
    }

    public function testDivideBy()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42)
        );
        $number = $addition->divideBy(new Number\Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(22, $number->value());
    }

    public function testMulitplyBy()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Number\Number(42)
        );
        $number = $addition->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testRound()
    {
        $addition = new Addition(
            new Number\Number(2.1),
            new Number\Number(4.24)
        );
        $number = $addition->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(6.3, $number->value());
    }

    public function testFloor()
    {
        $addition = new Addition(
            new Number\Number(2.1),
            new Number\Number(4.24)
        );
        $number = $addition->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $addition = new Addition(
            new Number\Number(2.1),
            new Number\Number(4.24)
        );
        $number = $addition->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testStringCast()
    {
        $addition = new Addition(
            new Number\Number(24),
            new Addition(
                new Number\Number(42),
                new Number\Number(66)
            )
        );

        $this->assertSame('24 + (42 + 66)', $addition->toString());
    }

    public function testModulo()
    {
        $addition = new Addition(
            new Number\Number(2.1),
            new Number\Number(4.24)
        );
        $number = $addition->modulo(new Number\Number(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.04, $number->value());
    }

    public function testAbsolute()
    {
        $addition = new Addition(
            new Number\Number(2.1),
            new Number\Number(4.24)
        );
        $number = $addition->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(6.34, $number->value());
    }

    public function testPower()
    {
        $addition = new Addition(
            new Number\Number(2),
            new Number\Number(4)
        );
        $number = $addition->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $addition = new Addition(
            new Number\Number(2),
            new Number\Number(2)
        );
        $number = $addition->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Addition(
            new Number\Number(2),
            new Number\Number(2)
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Addition(
            new Number\Number(2),
            new Number\Number(2)
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Addition(
            new Number\Number(2),
            new Number\Number(2)
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Addition(
            new Number\Number(2),
            new Number\Number(2)
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Addition(
            new Number\Number(2),
            new Number\Number(2)
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
