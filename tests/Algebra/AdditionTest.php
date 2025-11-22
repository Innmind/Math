<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    public function testInterface()
    {
        $addition = Number::of(24)
            ->add(Number::of(42))
            ->add(Number::of(66));

        $this->assertInstanceOf(Number::class, $addition);
        $this->assertSame('24 + 42 + 66', $addition->toString());
    }

    public function testResult()
    {
        $addition = Number::of(24)
            ->add(Number::of(42))
            ->add(Number::of(66));

        $this->assertInstanceOf(Number::class, $addition);
        $this->assertSame(132, $addition->value());
    }

    public function testValue()
    {
        $addition = Number::of(24)
            ->add(Number::of(42))
            ->add(Number::of(66));

        $this->assertSame(132, $addition->value());
    }

    public function testEquals()
    {
        $addition = Number::of(24)
            ->add(Number::of(42))
            ->add(Number::of(66));

        $this->assertTrue($addition->equals(Number::of(132)));
        $this->assertFalse($addition->equals(Number::of(131)));
    }

    public function testHigherThan()
    {
        $addition = Number::of(24)
            ->add(Number::of(42))
            ->add(Number::of(66));

        $this->assertFalse($addition->higherThan(Number::of(132)));
        $this->assertTrue($addition->higherThan(Number::of(131)));
    }

    public function testAdd()
    {
        $addition = Number::of(24)
            ->add(Number::of(42));
        $number = $addition->add(Number::of(66));

        $this->assertSame(132, $number->value());
    }

    public function testSubtract()
    {
        $addition = Number::of(24)
            ->add(Number::of(42));
        $number = $addition->subtract(Number::of(66));

        $this->assertSame(0, $number->value());
    }

    public function testDivideBy()
    {
        $addition = Number::of(24)
            ->add(Number::of(42));
        $number = $addition->divideBy(Number::of(3));

        $this->assertSame(22, $number->value());
    }

    public function testMulitplyBy()
    {
        $addition = Number::of(24)
            ->add(Number::of(42));
        $number = $addition->multiplyBy(Number::of(2));

        $this->assertSame(132, $number->value());
    }

    public function testFloor()
    {
        $addition = Number::of(2.1)->add(
            Number::of(4.24),
        );
        $number = $addition->floor();

        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $addition = Number::of(2.1)->add(
            Number::of(4.24),
        );
        $number = $addition->ceil();

        $this->assertSame(7.0, $number->value());
    }

    public function testStringCast()
    {
        $addition = Number::of(24)->add(
            Number::of(42)->add(Number::of(66)),
        );

        $this->assertSame('24 + (42 + 66)', $addition->toString());
    }

    public function testModulo()
    {
        $addition = Number::of(2.1)->add(
            Number::of(4.24),
        );
        $number = $addition->modulo(Number::of(0.1));

        $this->assertEqualsWithDelta(0.04, $number->value(), 0.0001);
    }

    public function testAbsolute()
    {
        $addition = Number::of(2.1)->add(
            Number::of(4.24),
        );
        $number = $addition->absolute();

        $this->assertSame(6.34, $number->value());
    }

    public function testPower()
    {
        $addition = Number::of(2)->add(
            Number::of(4),
        );
        $number = $addition->power(Number::of(2));

        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $addition = Number::of(2)->add(
            Number::of(2),
        );
        $number = $addition->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(2)
            ->add(Number::of(2))
            ->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)
            ->add(Number::of(2))
            ->binaryLogarithm();

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)
            ->add(Number::of(2))
            ->naturalLogarithm();

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)
            ->add(Number::of(2))
            ->commonLogarithm();

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)
            ->add(Number::of(2))
            ->signum();

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
