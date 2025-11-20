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
    Signum,
    Real,
    Value,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExponentialTest extends TestCase
{
    public function testInterface()
    {
        $power = Exponential::of(
            Value::zero,
        );

        $this->assertInstanceOf(Number::class, $power);
        $this->assertInstanceOf(Operation::class, $power);
    }

    public function testResult()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $result = $power->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(8.166169912567652, $result->value());
    }

    public function testStringCast()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );

        $this->assertSame('e^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = Exponential::of(
            Addition::of(
                Real::of(2),
                Real::of(2),
            ),
        );

        $this->assertSame('e^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );

        $this->assertTrue($power->equals(Real::of(8.166169912567652)));
        $this->assertFalse($power->equals(Real::of(8.16)));
    }

    public function testHigherThan()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );

        $this->assertTrue($power->higherThan(Real::of(8.16)));
        $this->assertFalse($power->higherThan(Real::of(8.166169912567652)));
    }

    public function testAdd()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(74.16616991256765, $number->value());
    }

    public function testSubtract()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-57.83383008743235, $number->value());
    }

    public function testDivideBy()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(4.083084956283826, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(16.332339825135303, $number->value());
    }

    public function testRound()
    {
        $number = Exponential::of(
            Real::of(2.1),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(8.0, $number->value());
    }

    public function testCeil()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testModulo()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->modulo(Real::of(8));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.16616991256765168, $number->value());
    }

    public function testAbsolute()
    {
        $power = Exponential::of(
            Real::of(-2.1),
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.1224564282529819, $number->value());
    }

    public function testPower()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(66.68633104092517, $number->value());
    }

    public function testSquareRoot()
    {
        $power = Exponential::of(
            Real::of(2.1),
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.857651118063164, $number->value());
    }

    public function testExponential()
    {
        $number = Exponential::of(Real::of(0))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(1), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Exponential::of(Real::of(1))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\exp(1), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Exponential::of(Real::of(1))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\exp(1)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Exponential::of(Real::of(1))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\exp(1)), $number->value());
    }

    public function testSignum()
    {
        $number = Exponential::of(Real::of(1))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
