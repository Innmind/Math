<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
{
    public function testInterface()
    {
        $subtraction = Number::of(4)->subtract(
            Number::of(2),
        );

        $this->assertInstanceOf(Number::class, $subtraction);
        $this->assertSame('4 - 2', $subtraction->toString());
    }

    public function testResult()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );

        $this->assertInstanceOf(Number::class, $subtraction);
        $this->assertSame(18, $subtraction->value());
    }

    public function testValue()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );

        $this->assertSame(18, $subtraction->value());
    }

    public function testEquals()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );

        $this->assertTrue($subtraction->equals(Number::of(18)));
        $this->assertFalse($subtraction->equals(Number::of(18.1)));
    }

    public function testHigherThan()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );

        $this->assertFalse($subtraction->higherThan(Number::of(18)));
        $this->assertTrue($subtraction->higherThan(Number::of(17.9)));
    }

    public function testAdd()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );
        $number = $subtraction->add(Number::of(66));

        $this->assertSame(84, $number->value());
    }

    public function testSubtract()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );
        $number = $subtraction->subtract(Number::of(66));

        $this->assertSame(-48, $number->value());
    }

    public function testDivideBy()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );
        $number = $subtraction->divideBy(Number::of(3));

        $this->assertSame(6, $number->value());
    }

    public function testMulitplyBy()
    {
        $subtraction = Number::of(42)->subtract(
            Number::of(24),
        );
        $number = $subtraction->multiplyBy(Number::of(2));

        $this->assertSame(36, $number->value());
    }

    public function testFloor()
    {
        $subtraction = Number::of(24.55)->subtract(
            Number::of(12.33),
        );
        $number = $subtraction->floor();

        $this->assertSame(12.0, $number->value());
    }

    public function testCeil()
    {
        $subtraction = Number::of(24.55)->subtract(
            Number::of(12.33),
        );
        $number = $subtraction->ceil();

        $this->assertSame(13.0, $number->value());
    }

    public function testModulo()
    {
        $subtraction = Number::of(25)->subtract(
            Number::of(12),
        );
        $number = $subtraction->modulo(Number::of(6));

        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $subtraction = Number::of(12)->subtract(
            Number::of(25),
        );
        $number = $subtraction->absolute();

        $this->assertSame(13, $number->value());
    }

    public function testPower()
    {
        $subtraction = Number::of(12)->subtract(
            Number::of(6),
        );
        $number = $subtraction->power(Number::of(2));

        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $subtraction = Number::of(8)->subtract(
            Number::of(4),
        );
        $number = $subtraction->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(8)
            ->subtract(Number::of(4))
            ->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(8)
            ->subtract(Number::of(4))
            ->binaryLogarithm();

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(8)
            ->subtract(Number::of(4))
            ->naturalLogarithm();

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(8)
            ->subtract(Number::of(4))
            ->commonLogarithm();

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(4)
            ->subtract(Number::of(3))
            ->signum();

        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $subtraction = Number::of(12)
            ->add(Number::of(12))
            ->subtract(Number::of(42))
            ->subtract(Number::of(66));

        $this->assertSame('(12 + 12) - 42 - 66', $subtraction->toString());
    }
}
