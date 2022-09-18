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
        $subtraction = Subtraction::of(
            Number\Number::of(4),
            Number\Number::of(2),
        );

        $this->assertInstanceOf(Operation::class, $subtraction);
        $this->assertInstanceOf(Number::class, $subtraction);
        $this->assertSame('4 - 2', $subtraction->toString());
    }

    public function testResult()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );
        $result = $subtraction->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(18, $result->value());
        $this->assertTrue($result->equals($subtraction->difference()));
    }

    public function testValue()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );

        $this->assertSame(18, $subtraction->value());
    }

    public function testEquals()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );

        $this->assertTrue($subtraction->equals(Number\Number::of(18)));
        $this->assertFalse($subtraction->equals(Number\Number::of(18.1)));
    }

    public function testHigherThan()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );

        $this->assertFalse($subtraction->higherThan(Number\Number::of(18)));
        $this->assertTrue($subtraction->higherThan(Number\Number::of(17.9)));
    }

    public function testAdd()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );
        $number = $subtraction->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testSubtract()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );
        $number = $subtraction->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-48, $number->value());
    }

    public function testDivideBy()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );
        $number = $subtraction->divideBy(Number\Number::of(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testMulitplyBy()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(42),
            Number\Number::of(24),
        );
        $number = $subtraction->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testRound()
    {
        $number = Subtraction::of(
            Number\Number::of(24.55),
            Number\Number::of(12.33),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(24.55),
            Number\Number::of(12.33),
        );
        $number = $subtraction->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(12.0, $number->value());
    }

    public function testCeil()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(24.55),
            Number\Number::of(12.33),
        );
        $number = $subtraction->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(13.0, $number->value());
    }

    public function testModulo()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(25),
            Number\Number::of(12),
        );
        $number = $subtraction->modulo(Number\Number::of(6));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(12),
            Number\Number::of(25),
        );
        $number = $subtraction->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(13, $number->value());
    }

    public function testPower()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(12),
            Number\Number::of(6),
        );
        $number = $subtraction->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $subtraction = Subtraction::of(
            Number\Number::of(8),
            Number\Number::of(4),
        );
        $number = $subtraction->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Subtraction::of(
            Number\Number::of(8),
            Number\Number::of(4),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Subtraction::of(
            Number\Number::of(8),
            Number\Number::of(4),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Subtraction::of(
            Number\Number::of(8),
            Number\Number::of(4),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Subtraction::of(
            Number\Number::of(8),
            Number\Number::of(4),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Subtraction::of(
            Number\Number::of(4),
            Number\Number::of(3),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $subtraction = Subtraction::of(
            Addition::of(
                Number\Number::of(12),
                Number\Number::of(12),
            ),
            Number\Number::of(42),
            Number\Number::of(66),
        );

        $this->assertSame('(12 + 12) - 42 - 66', $subtraction->toString());
    }
}
