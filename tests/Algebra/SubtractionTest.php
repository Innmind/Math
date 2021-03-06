<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Subtraction,
    Number,
    Operation,
    Addition,
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
    CommonLogarithm,
    Signum
};
use PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
{
    public function testInterface()
    {
        $subtraction = new Subtraction(
            new Number\Number(4),
            new Number\Number(2)
        );

        $this->assertInstanceOf(Operation::class, $subtraction);
        $this->assertInstanceOf(Number::class, $subtraction);
        $this->assertSame('4 - 2', $subtraction->toString());
    }

    public function testResult()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );
        $result = $subtraction->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(18, $result->value());
        $this->assertTrue($result->equals($subtraction->difference()));
        $this->assertSame($result, $subtraction->result());
    }

    public function testValue()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );

        $this->assertSame(18, $subtraction->value());
    }

    public function testEquals()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );

        $this->assertTrue($subtraction->equals(new Number\Number(18)));
        $this->assertFalse($subtraction->equals(new Number\Number(18.1)));
    }

    public function testHigherThan()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );

        $this->assertFalse($subtraction->higherThan(new Number\Number(18)));
        $this->assertTrue($subtraction->higherThan(new Number\Number(17.9)));
    }

    public function testAdd()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );
        $number = $subtraction->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testSubtract()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );
        $number = $subtraction->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-48, $number->value());
    }

    public function testDivideBy()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );
        $number = $subtraction->divideBy(new Number\Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testMulitplyBy()
    {
        $subtraction = new Subtraction(
            new Number\Number(42),
            new Number\Number(24)
        );
        $number = $subtraction->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testRound()
    {
        $number = new Subtraction(
            new Number\Number(24.55),
            new Number\Number(12.33)
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $subtraction = new Subtraction(
            new Number\Number(24.55),
            new Number\Number(12.33)
        );
        $number = $subtraction->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(12.0, $number->value());
    }

    public function testCeil()
    {
        $subtraction = new Subtraction(
            new Number\Number(24.55),
            new Number\Number(12.33)
        );
        $number = $subtraction->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(13.0, $number->value());
    }

    public function testModulo()
    {
        $subtraction = new Subtraction(
            new Number\Number(25),
            new Number\Number(12)
        );
        $number = $subtraction->modulo(new Number\Number(6));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $subtraction = new Subtraction(
            new Number\Number(12),
            new Number\Number(25)
        );
        $number = $subtraction->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(13, $number->value());
    }

    public function testPower()
    {
        $subtraction = new Subtraction(
            new Number\Number(12),
            new Number\Number(6)
        );
        $number = $subtraction->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $subtraction = new Subtraction(
            new Number\Number(8),
            new Number\Number(4)
        );
        $number = $subtraction->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Subtraction(
            new Number\Number(8),
            new Number\Number(4)
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Subtraction(
            new Number\Number(8),
            new Number\Number(4)
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Subtraction(
            new Number\Number(8),
            new Number\Number(4)
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Subtraction(
            new Number\Number(8),
            new Number\Number(4)
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Subtraction(
            new Number\Number(4),
            new Number\Number(3)
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $subtraction = new Subtraction(
            new Addition(
                new Number\Number(12),
                new Number\Number(12)
            ),
            new Number\Number(42),
            new Number\Number(66)
        );

        $this->assertSame('(12 + 12) - 42 - 66', $subtraction->toString());
    }
}
