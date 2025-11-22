<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class FloorTest extends TestCase
{
    public function testInterface()
    {
        $floor = Number::of(42.42)->floor();

        $this->assertInstanceOf(Number::class, $floor);
    }

    #[DataProvider('values')]
    public function testValue($number, $expected)
    {
        $floor = Number::of($number)->floor();

        $this->assertSame($expected, $floor->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '42.0',
            Number::of(42.45)->floor()->toString(),
        );
    }

    public function testEquals()
    {
        $floor = Number::of(42.45)->floor();

        $this->assertTrue($floor->equals(Number::of(42)));
        $this->assertTrue($floor->equals(Number::of(42.0)));
        $this->assertFalse($floor->equals(Number::of(43)));
    }

    public function testHigherThan()
    {
        $floor = Number::of(42.45)->floor();

        $this->assertTrue($floor->higherThan(Number::of(41.9)));
        $this->assertFalse($floor->higherThan(Number::of(42.5)));
    }

    public function testAdd()
    {
        $floor = Number::of(42.5)->floor();
        $number = $floor->add(Number::of(7));

        $this->assertSame(49.0, $number->value());
    }

    public function testSubtract()
    {
        $floor = Number::of(42.5)->floor();
        $number = $floor->subtract(Number::of(7));

        $this->assertSame(35.0, $number->value());
    }

    public function testMultiplication()
    {
        $floor = Number::of(42.5)->floor();
        $number = $floor->multiplyBy(Number::of(2));

        $this->assertSame(84.0, $number->value());
    }

    public function testDivision()
    {
        $floor = Number::of(42.5)->floor();
        $number = $floor->divideBy(Number::of(2));

        $this->assertSame(21.0, $number->value());
    }

    public function testFloor()
    {
        $floor = Number::of(42.45)->floor();
        $number = $floor->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $floor = Number::of(42.45)->floor();
        $number = $floor->ceil();

        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $floor = Number::of(42.45)->floor();
        $number = $floor->modulo(Number::of(20));

        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $floor = Number::of(-42.45)->floor();
        $number = $floor->absolute();

        $this->assertSame(43.0, $number->value());
    }

    public function testPower()
    {
        $floor = Number::of(2.5)->floor();
        $number = $floor->power(Number::of(2));

        $this->assertSame(4.0, $number->value());
    }

    public function testSquareRoot()
    {
        $floor = Number::of(4.5)->floor();
        $number = $floor->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(4.5)->floor()->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(3.5)->floor()->binaryLogarithm();

        $this->assertSame(\log(3, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(3.5)->floor()->naturalLogarithm();

        $this->assertSame(\log(3), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(3.5)->floor()->commonLogarithm();

        $this->assertSame(\log10(3), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->floor()->signum();

        $this->assertSame(1, $number->value());
    }

    public static function values(): array
    {
        return [
            [42.4, 42.0],
            [42.5, 42.0],
            [42.6, 42.0],
            [42.51, 42.0],
        ];
    }
}
