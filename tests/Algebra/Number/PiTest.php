<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PiTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Number::pi());
    }

    public function testStringCast()
    {
        $this->assertSame('π', Number::pi()->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Number::pi()->equals(Number::of(3.141592653589793)));
        $this->assertFalse(Number::pi()->equals(Number::of(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue(Number::pi()->higherThan(Number::of(3.14)));
        $this->assertFalse(Number::pi()->higherThan(Number::of(3.15)));
    }

    public function testAdd()
    {
        $number = Number::pi();
        $number = $number->add(Number::of(66));

        $this->assertSame(69.1415926535898, $number->value());
    }

    public function testSubtract()
    {
        $number = Number::pi();
        $number = $number->subtract(Number::of(66));

        $this->assertSame(-62.8584073464102, $number->value());
    }

    public function testDivideBy()
    {
        $number = Number::pi();
        $number = $number->divideBy(Number::of(2));

        $this->assertSame(\M_PI_2, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Number::pi();
        $number = $number->multiplyBy(Number::of(2));

        $this->assertSame(\pi() * 2, $number->value());
    }

    public function testFloor()
    {
        $number = Number::pi();
        $number = $number->floor();

        $this->assertSame(3.0, $number->value());
    }

    public function testCeil()
    {
        $number = Number::pi();
        $number = $number->ceil();

        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $number = Number::pi();
        $number = $number->modulo(Number::of(0.1));

        $this->assertSame(0.041592653589792944, $number->value());
    }

    public function testAbsolute()
    {
        $number = Number::pi();
        $number = $number->absolute();

        $this->assertSame(Number::pi()->value(), $number->value());
    }

    public function testPower()
    {
        $number = Number::pi();
        $number = $number->power(Number::of(2));

        $this->assertSame(
            Number::pi()->multiplyBy(Number::pi())->value(),
            $number->value(),
        );
    }

    public function testSquareRoot()
    {
        $number = Number::pi();
        $number = $number->squareRoot();

        $this->assertEqualsWithDelta(\M_SQRTPI, $number->value(), 0.000000000000001);
        $this->assertSame(1.7724538509055159, $number->value());
    }

    public function testExponential()
    {
        $number = Number::pi()->exponential();

        $this->assertSame(\exp(\M_PI), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::pi()->binaryLogarithm();

        $this->assertSame(\log(\M_PI, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::pi()->naturalLogarithm();

        $this->assertSame(\log(\M_PI), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::pi()->commonLogarithm();

        $this->assertSame(\log10(\M_PI), $number->value());
    }

    public function testSignum()
    {
        $number = Number::pi()->signum();

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
