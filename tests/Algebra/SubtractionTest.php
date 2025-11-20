<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Subtraction,
    Number,
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
    Signum,
    Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
{
    public function testInterface()
    {
        $subtraction = Subtraction::of(
            Real::of(4),
            Real::of(2),
        );

        $this->assertInstanceOf(Number::class, $subtraction);
        $this->assertSame('4 - 2', $subtraction->toString());
    }

    public function testResult()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );
        $result = $subtraction->difference();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(18, $result->value());
    }

    public function testValue()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );

        $this->assertSame(18, $subtraction->value());
    }

    public function testEquals()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );

        $this->assertTrue($subtraction->equals(Real::of(18)));
        $this->assertFalse($subtraction->equals(Real::of(18.1)));
    }

    public function testHigherThan()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );

        $this->assertFalse($subtraction->higherThan(Real::of(18)));
        $this->assertTrue($subtraction->higherThan(Real::of(17.9)));
    }

    public function testAdd()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );
        $number = $subtraction->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testSubtract()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );
        $number = $subtraction->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-48, $number->value());
    }

    public function testDivideBy()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );
        $number = $subtraction->divideBy(Real::of(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testMulitplyBy()
    {
        $subtraction = Subtraction::of(
            Real::of(42),
            Real::of(24),
        );
        $number = $subtraction->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testRound()
    {
        $number = Subtraction::of(
            Real::of(24.55),
            Real::of(12.33),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $subtraction = Subtraction::of(
            Real::of(24.55),
            Real::of(12.33),
        );
        $number = $subtraction->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(12.0, $number->value());
    }

    public function testCeil()
    {
        $subtraction = Subtraction::of(
            Real::of(24.55),
            Real::of(12.33),
        );
        $number = $subtraction->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(13.0, $number->value());
    }

    public function testModulo()
    {
        $subtraction = Subtraction::of(
            Real::of(25),
            Real::of(12),
        );
        $number = $subtraction->modulo(Real::of(6));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $subtraction = Subtraction::of(
            Real::of(12),
            Real::of(25),
        );
        $number = $subtraction->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(13, $number->value());
    }

    public function testPower()
    {
        $subtraction = Subtraction::of(
            Real::of(12),
            Real::of(6),
        );
        $number = $subtraction->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $subtraction = Subtraction::of(
            Real::of(8),
            Real::of(4),
        );
        $number = $subtraction->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Subtraction::of(
            Real::of(8),
            Real::of(4),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Subtraction::of(
            Real::of(8),
            Real::of(4),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Subtraction::of(
            Real::of(8),
            Real::of(4),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Subtraction::of(
            Real::of(8),
            Real::of(4),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Subtraction::of(
            Real::of(4),
            Real::of(3),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $subtraction = Subtraction::of(
            Addition::of(
                Real::of(12),
                Real::of(12),
            ),
            Real::of(42),
            Real::of(66),
        );

        $this->assertSame('(12 + 12) - 42 - 66', $subtraction->toString());
    }
}
