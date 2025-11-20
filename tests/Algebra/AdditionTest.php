<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Addition,
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
    Signum,
    Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    public function testInterface()
    {
        $addition = Real::of(24)
            ->add(Real::of(42))
            ->add(Real::of(66));

        $this->assertInstanceOf(Number::class, $addition);
        $this->assertSame('24 + 42 + 66', $addition->toString());
    }

    public function testResult()
    {
        $addition = Real::of(24)
            ->add(Real::of(42))
            ->add(Real::of(66));
        $result = $addition->sum();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(132, $result->value());
    }

    public function testValue()
    {
        $addition = Real::of(24)
            ->add(Real::of(42))
            ->add(Real::of(66));

        $this->assertSame(132, $addition->value());
    }

    public function testEquals()
    {
        $addition = Real::of(24)
            ->add(Real::of(42))
            ->add(Real::of(66));

        $this->assertTrue($addition->equals(Real::of(132)));
        $this->assertFalse($addition->equals(Real::of(131)));
    }

    public function testHigherThan()
    {
        $addition = Real::of(24)
            ->add(Real::of(42))
            ->add(Real::of(66));

        $this->assertFalse($addition->higherThan(Real::of(132)));
        $this->assertTrue($addition->higherThan(Real::of(131)));
    }

    public function testAdd()
    {
        $addition = Real::of(24)
            ->add(Real::of(42));
        $number = $addition->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testSubtract()
    {
        $addition = Real::of(24)
            ->add(Real::of(42));
        $number = $addition->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(0, $number->value());
    }

    public function testDivideBy()
    {
        $addition = Real::of(24)
            ->add(Real::of(42));
        $number = $addition->divideBy(Real::of(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(22, $number->value());
    }

    public function testMulitplyBy()
    {
        $addition = Real::of(24)
            ->add(Real::of(42));
        $number = $addition->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testRound()
    {
        $number = Real::of(2.1)->add(
            Real::of(4.24),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $addition = Real::of(2.1)->add(
            Real::of(4.24),
        );
        $number = $addition->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $addition = Real::of(2.1)->add(
            Real::of(4.24),
        );
        $number = $addition->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testStringCast()
    {
        $addition = Real::of(24)->add(
            Real::of(42)->add(Real::of(66)),
        );

        $this->assertSame('24 + (42 + 66)', $addition->toString());
    }

    public function testModulo()
    {
        $addition = Real::of(2.1)->add(
            Real::of(4.24),
        );
        $number = $addition->modulo(Real::of(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertEqualsWithDelta(0.04, $number->value(), 0.0001);
    }

    public function testAbsolute()
    {
        $addition = Real::of(2.1)->add(
            Real::of(4.24),
        );
        $number = $addition->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(6.34, $number->value());
    }

    public function testPower()
    {
        $addition = Real::of(2)->add(
            Real::of(4),
        );
        $number = $addition->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $addition = Real::of(2)->add(
            Real::of(2),
        );
        $number = $addition->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Real::of(2)
            ->add(Real::of(2))
            ->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Real::of(2)
            ->add(Real::of(2))
            ->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Real::of(2)
            ->add(Real::of(2))
            ->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Real::of(2)
            ->add(Real::of(2))
            ->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Real::of(2)
            ->add(Real::of(2))
            ->signum();

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
