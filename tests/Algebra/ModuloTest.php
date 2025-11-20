<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Modulo,
    Operation,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
    Real,
    Value,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ModuloTest extends TestCase
{
    public function testInterface()
    {
        $modulo = Modulo::of(
            Value::one,
            Value::one,
        );

        $this->assertInstanceOf(Number::class, $modulo);
        $this->assertInstanceOf(Operation::class, $modulo);
    }

    public function testResult()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $result = $modulo->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertEqualsWithDelta(0.24, $result->value(), 0.0001);
    }

    public function testStringCast()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );

        $this->assertSame('42.24 % 2.1', $modulo->toString());
    }

    public function testStringCastOperations()
    {
        $modulo = Modulo::of(
            Addition::of(
                Real::of(1),
                Real::of(1),
            ),
            Addition::of(
                Real::of(2),
                Real::of(2),
            ),
        );

        $this->assertSame('(1 + 1) % (2 + 2)', $modulo->toString());
    }

    public function testEquals()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );

        $this->assertTrue($modulo->equals(Real::of(0.2400000000000002)));
        $this->assertFalse($modulo->equals(Real::of(1.24)));
    }

    public function testHigherThan()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );

        $this->assertTrue($modulo->higherThan(Real::of(0.23)));
        $this->assertFalse($modulo->higherThan(Real::of(0.2400000000000002)));
    }

    public function testAdd()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(66.24, $number->value());
    }

    public function testSubtract()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.76, $number->value());
    }

    public function testDivideBy()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertEqualsWithDelta(
            0.12,
            $number->value(),
            0.001,
        );
    }

    public function testMulitplyBy()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertEqualsWithDelta(0.48, $number->value(), 0.0001);
    }

    public function testRound()
    {
        $number = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $modulo = Modulo::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $number = $modulo->modulo(Real::of(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertEqualsWithDelta(
            0.04,
            $number->value(),
            0.001,
        );
    }

    public function testAbsolute()
    {
        $modulo = Modulo::of(
            Real::of(-42.24),
            Real::of(2.1),
        );
        $number = $modulo->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertEqualsWithDelta(0.24, $number->value(), 0.00001);
    }

    public function testPower()
    {
        $modulo = Modulo::of(
            Real::of(9),
            Real::of(2),
        );
        $number = $modulo->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testSquareRoot()
    {
        $modulo = Modulo::of(
            Real::of(12),
            Real::of(8),
        );
        $number = $modulo->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Modulo::of(
            Real::of(12),
            Real::of(8),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Modulo::of(
            Real::of(12),
            Real::of(8),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Modulo::of(
            Real::of(12),
            Real::of(8),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Modulo::of(
            Real::of(12),
            Real::of(8),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Modulo::of(
            Real::of(12),
            Real::of(8),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    private function assertEqualsWithDelta(
        int|float $expected,
        int|float $value,
        int|float $delta,
    ): void {
        $this->assertGreaterThanOrEqual($expected-$delta, $value);
        $this->assertLessThanOrEqual($expected+$delta, $value);
    }
}
