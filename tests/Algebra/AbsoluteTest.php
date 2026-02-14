<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AbsoluteTest extends TestCase
{
    public function testInterface()
    {
        $absolute = Number::of(42.42)->absolute();

        $this->assertInstanceOf(Number::class, $absolute);
    }

    #[DataProvider('values')]
    public function testValue($number, $expected)
    {
        $absolute = Number::of($number)->absolute();

        $this->assertSame($expected, $absolute->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '|42.45|',
            Number::of(42.45)->absolute()->toString(),
        );
    }

    public function testEquals()
    {
        $absolute = Number::of(-42.45)->absolute();

        $this->assertTrue($absolute->equals(Number::of(42.45)));
        $this->assertFalse($absolute->equals(Number::of(-42.45)));
    }

    public function testHigherThan()
    {
        $absolute = Number::of(-42.45)->absolute();

        $this->assertTrue($absolute->higherThan(Number::of(0)));
        $this->assertFalse($absolute->higherThan(Number::of(43)));
    }

    public function testAdd()
    {
        $absolute = Number::of(-43)->absolute();
        $number = $absolute->add(Number::of(7));

        $this->assertSame(50, $number->value());
    }

    public function testSubtract()
    {
        $absolute = Number::of(-43)->absolute();
        $number = $absolute->subtract(Number::of(7));

        $this->assertSame(36, $number->value());
    }

    public function testMultiplication()
    {
        $absolute = Number::of(-43)->absolute();
        $number = $absolute->multiplyBy(Number::of(2));

        $this->assertSame(86, $number->value());
    }

    public function testDivision()
    {
        $absolute = Number::of(-43)->absolute();
        $number = $absolute->divideBy(Number::of(2));

        $this->assertSame(21.5, $number->value());
    }

    public function testFloor()
    {
        $absolute = Number::of(-42.45)->absolute();
        $number = $absolute->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $absolute = Number::of(-42.45)->absolute();
        $number = $absolute->ceil();

        $this->assertSame(43.0, $number->value());
    }

    public function testAbsolute()
    {
        $absolute = Number::of(-42.45)->absolute();
        $number = $absolute->absolute();

        $this->assertSame(42.45, $number->value());
    }

    public function testModulo()
    {
        $absolute = Number::of(-42.45)->absolute();
        $number = $absolute->modulo(Number::of(2.1));

        $this->assertEqualsWithDelta(0.45, $number->value(), 0.001);
    }

    public function testPower()
    {
        $absolute = Number::of(-4)->absolute();
        $number = $absolute->power(Number::of(2));

        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $absolute = Number::of(-4)->absolute();
        $number = $absolute->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(-4)->absolute()->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(-4)->absolute()->signum();

        $this->assertSame(1, $number->value());
    }

    public static function values(): array
    {
        return [
            [-1, 1],
            [1, 1],
        ];
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
