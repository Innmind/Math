<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ETest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Number::e());
    }

    public function testStringCast()
    {
        $this->assertSame('e', Number::e()->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Number::e()->equals(Number::of(\M_E)));
        $this->assertFalse(Number::e()->equals(Number::of(2.718)));
    }

    public function testHigherThan()
    {
        $this->assertTrue(Number::e()->higherThan(Number::of(2.718)));
        $this->assertFalse(Number::e()->higherThan(Number::of(\M_E)));
    }

    public function testAdd()
    {
        $number = Number::e();
        $number = $number->add(Number::of(66));

        $this->assertSame(68.71828182845904, $number->value());
    }

    public function testSubtract()
    {
        $number = Number::e();
        $number = $number->subtract(Number::of(2));

        $this->assertSame(0.7182818284590451, $number->value());
    }

    public function testDivideBy()
    {
        $number = Number::e();
        $number = $number->divideBy(Number::of(2));

        $this->assertSame(\M_E / 2, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Number::e();
        $number = $number->multiplyBy(Number::of(2));

        $this->assertSame(\M_E * 2, $number->value());
    }

    public function testFloor()
    {
        $number = Number::e();
        $number = $number->floor();

        $this->assertSame(2.0, $number->value());
    }

    public function testCeil()
    {
        $number = Number::e();
        $number = $number->ceil();

        $this->assertSame(3.0, $number->value());
    }

    public function testModulo()
    {
        $number = Number::e();
        $number = $number->modulo(Number::of(2));

        $this->assertSame(0.7182818284590451, $number->value());
    }

    public function testAbsolute()
    {
        $number = Number::e();
        $number = $number->absolute();

        $this->assertSame(\M_E, $number->value());
    }

    public function testPower()
    {
        $number = Number::e();
        $number = $number->power(Number::of(2));

        $this->assertEqualsWithDelta(\exp(2), $number->value(), 0.00000000000001);
        $this->assertSame(7.3890560989306495, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Number::e();
        $number = $number->squareRoot();

        $this->assertSame(\sqrt(\M_E), $number->value());
    }

    public function testExponential()
    {
        $number = Number::e()->exponential();

        $this->assertSame(\exp(\M_E), $number->value());
    }

    public function testSignum()
    {
        $number = Number::e()->signum();

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
