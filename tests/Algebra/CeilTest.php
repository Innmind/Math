<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CeilTest extends TestCase
{
    public function testInterface()
    {
        $ceil = Number::of(42.42)->ceil();

        $this->assertInstanceOf(Number::class, $ceil);
    }

    #[DataProvider('values')]
    public function testValue($number, $expected)
    {
        $ceil = Number::of($number)->ceil();

        $this->assertSame($expected, $ceil->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '43.0',
            Number::of(42.45)->ceil()->toString(),
        );
    }

    public function testEquals()
    {
        $ceil = Number::of(42.45)->ceil();

        $this->assertTrue($ceil->equals(Number::of(43)));
        $this->assertTrue($ceil->equals(Number::of(43.0)));
        $this->assertFalse($ceil->equals(Number::of(42)));
    }

    public function testHigherThan()
    {
        $ceil = Number::of(42.45)->ceil();

        $this->assertTrue($ceil->higherThan(Number::of(41.9)));
        $this->assertFalse($ceil->higherThan(Number::of(43.5)));
    }

    public function testAdd()
    {
        $ceil = Number::of(42.5)->ceil();
        $number = $ceil->add(Number::of(7));

        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $ceil = Number::of(42.5)->ceil();
        $number = $ceil->subtract(Number::of(7));

        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $ceil = Number::of(42.5)->ceil();
        $number = $ceil->multiplyBy(Number::of(2));

        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $ceil = Number::of(42.5)->ceil();
        $number = $ceil->divideBy(Number::of(2));

        $this->assertSame(21.5, $number->value());
    }

    public function testFloor()
    {
        $ceil = Number::of(42.45)->ceil();
        $number = $ceil->floor();

        $this->assertSame(43.0, $number->value());
    }

    public function testCeil()
    {
        $ceil = Number::of(42.45)->ceil();
        $number = $ceil->ceil();

        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $ceil = Number::of(42.45)->ceil();
        $number = $ceil->modulo(Number::of(2.1));

        $this->assertEqualsWithDelta(1.0, $number->value(), 0.0001);
    }

    public function testAbsolute()
    {
        $ceil = Number::of(-42.45)->ceil();
        $number = $ceil->absolute();

        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $ceil = Number::of(2.5)->ceil();
        $number = $ceil->power(Number::of(2));

        $this->assertSame(9.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ceil = Number::of(3.5)->ceil();
        $number = $ceil->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(3.5)->ceil()->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(3.5)->ceil()->binaryLogarithm();

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(3.5)->ceil()->naturalLogarithm();

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(3.5)->ceil()->commonLogarithm();

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->ceil()->signum();

        $this->assertSame(1, $number->value());
    }

    public static function values(): array
    {
        return [
            [42.4, 43.0],
            [42.5, 43.0],
            [42.6, 43.0],
            [42.51, 43.0],
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
