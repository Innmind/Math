<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Factorial,
    Algebra\Number,
    Exception\FactorialMustBePositive
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class FactorialTest extends TestCase
{
    public function testThrowWhenNegativeFactorial()
    {
        $this->expectException(FactorialMustBePositive::class);

        Factorial::of(-1);
    }

    public function testStringCast()
    {
        $number = Factorial::of(3);

        $this->assertSame(6, $number->number()->value());
        $this->assertSame('3!', $number->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Factorial::of(3)->number()->equals(Factorial::of(3)->number()));
        $this->assertTrue(Factorial::of(3)->number()->equals(Number::of(6.0)));
        $this->assertFalse(Factorial::of(3)->number()->equals(Number::of(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse(Factorial::of(3)->number()->higherThan(Factorial::of(3)->number()));
        $this->assertTrue(Factorial::of(3)->number()->higherThan(Number::of(1.24)));
    }

    public function testAdd()
    {
        $number = Factorial::of(3)->number();
        $number = $number->add(Number::of(66));

        $this->assertSame(72, $number->value());
    }

    public function testSubtract()
    {
        $number = Factorial::of(3)->number();
        $number = $number->subtract(Number::of(66));

        $this->assertSame(-60, $number->value());
    }

    public function testDivideBy()
    {
        $number = Factorial::of(3)->number();
        $number = $number->divideBy(Number::of(2));

        $this->assertSame(3, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Factorial::of(3)->number();
        $number = $number->multiplyBy(Number::of(2));

        $this->assertSame(12, $number->value());
    }

    public function testFloor()
    {
        $number = Factorial::of(3)->number();
        $number = $number->floor();

        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $number = Factorial::of(3)->number();
        $number = $number->ceil();

        $this->assertSame(6.0, $number->value());
    }

    public function testModulo()
    {
        $number = Factorial::of(3)->number();
        $number = $number->modulo(Number::of(4));

        $this->assertSame(2, $number->value());
    }

    public function testAbsolute()
    {
        $number = Factorial::of(3)->number();
        $number = $number->absolute();

        $this->assertSame(6, $number->value());
    }

    public function testPower()
    {
        $number = Factorial::of(3)->number();
        $number = $number->power(Number::of(2));

        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Factorial::of(3)->number();
        $number = $number->squareRoot();

        $this->assertSame(2.449489742783178, $number->value());
    }

    public function testExponential()
    {
        $number = Factorial::of(4)->number()->exponential();

        $this->assertSame(\exp(24), $number->value());
    }

    public function testSignum()
    {
        $number = Factorial::of(4)->number()->signum();

        $this->assertSame(1, $number->value());
    }

    #[DataProvider('factorials')]
    public function testResult($integer, $expected)
    {
        $number = Factorial::of($integer)->number();

        $this->assertSame($expected, $number->value());
    }

    public static function factorials(): array
    {
        return [
            [0, 1],
            [1, 1],
            [2, 2],
            [3, 6],
            [4, 24],
            [10, 3628800],
            [100, 9.332621544394418E+157],
        ];
    }
}
