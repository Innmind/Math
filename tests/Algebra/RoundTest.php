<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class RoundTest extends TestCase
{
    public function testInterface()
    {
        $round = Number::of(42.42)->roundUp();

        $this->assertInstanceOf(Number::class, $round);
    }

    #[DataProvider('values')]
    public function testValue($number, $expected, $precision, $mode)
    {
        $round = Number::of($number)->$mode($precision);

        $this->assertSame($expected, $round->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '42.5',
            Number::of(42.45)->roundUp(1)->toString(),
        );
    }

    public function testEquals()
    {
        $round = Number::of(42.45)->roundUp(1);

        $this->assertTrue($round->equals(Number::of(42.5)));
        $this->assertTrue($round->equals(Number::of(
            42.499999999999999, # with a precision over 14 digits php will round it
        )));
        $this->assertFalse($round->equals(Number::of(42)));
    }

    public function testHigherThan()
    {
        $round = Number::of(42.45)->roundUp(1);

        $this->assertTrue($round->higherThan(Number::of(42.4)));
        $this->assertFalse($round->higherThan(Number::of(42.5)));
    }

    public function testAdd()
    {
        $round = Number::of(42.5)->roundUp();
        $number = $round->add(Number::of(7));

        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $round = Number::of(42.5)->roundUp();
        $number = $round->subtract(Number::of(7));

        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $round = Number::of(42.5)->roundUp();
        $number = $round->multiplyBy(Number::of(2));

        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $round = Number::of(42.5)->roundUp();
        $number = $round->divideBy(Number::of(2));

        $this->assertSame(21.5, $number->value());
    }

    public function testFloor()
    {
        $round = Number::of(42.45)->roundUp(1);
        $number = $round->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $round = Number::of(42.45)->roundUp(1);
        $number = $round->ceil();

        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $round = Number::of(42.45)->roundUp(1);
        $number = $round->modulo(Number::of(21));

        $this->assertSame(0.5, $number->value());
    }

    public function testAbsolute()
    {
        $round = Number::of(-42.45)->roundUp(1);
        $number = $round->absolute();

        $this->assertSame(42.5, $number->value());
    }

    public function testPower()
    {
        $round = Number::of(2.45)->roundUp(1);
        $number = $round->power(Number::of(2));

        $this->assertSame(6.25, $number->value());
    }

    public function testSquareRoot()
    {
        $round = Number::of(4.3)->roundUp();
        $number = $round->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(3.6)->roundUp()->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(3.6)->roundUp()->binaryLogarithm();

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(3.6)->roundUp()->naturalLogarithm();

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(3.6)->roundUp()->commonLogarithm();

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(1)->roundUp()->signum();

        $this->assertSame(1, $number->value());
    }

    public static function values(): array
    {
        return [
            [42.5, 43.0, 0, 'roundUp'],
            [42.5, 42.0, 0, 'roundDown'],
            [42.5, 42.0, 0, 'roundEven'],
            [42.5, 43.0, 0, 'roundOdd'],
            [42.51, 42.5, 1, 'roundUp'],
            [42.51, 42.5, 1, 'roundDown'],
            [42.51, 42.5, 1, 'roundEven'],
            [42.51, 42.5, 1, 'roundOdd'],
            [42.51, 42.51, 2, 'roundUp'],
            [42.51, 42.51, 2, 'roundDown'],
            [42.51, 42.51, 2, 'roundEven'],
            [42.51, 42.51, 2, 'roundOdd'],
        ];
    }
}
