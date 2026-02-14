<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Number,
    Exception\DivisionByZero,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DivisionTest extends TestCase
{
    public function testInterface()
    {
        $division = Number::of(4)->divideBy(
            Number::of(2),
        );

        $this->assertInstanceOf(Number::class, $division);
    }

    public function testResult()
    {
        $division = Number::of(4)->divideBy(Number::of(2));

        $this->assertInstanceOf(Number::class, $division);
        $this->assertSame(2, $division->value());
    }

    public function testValue()
    {
        $division = Number::of(4)->divideBy(Number::of(2));

        $this->assertSame(2, $division->value());
    }

    public function testEquals()
    {
        $division = Number::of(4)->divideBy(Number::of(2));

        $this->assertTrue($division->equals(Number::of(2)));
        $this->assertFalse($division->equals(Number::of(2.1)));
    }

    public function testHigherThan()
    {
        $division = Number::of(4)->divideBy(Number::of(2));

        $this->assertFalse($division->higherThan(Number::of(2)));
        $this->assertTrue($division->higherThan(Number::of(1.9)));
    }

    public function testAdd()
    {
        $division = Number::of(4)->divideBy(Number::of(2));
        $number = $division->add(Number::of(66));

        $this->assertSame(68, $number->value());
    }

    public function testSubtract()
    {
        $division = Number::of(4)->divideBy(Number::of(2));
        $number = $division->subtract(Number::of(66));

        $this->assertSame(-64, $number->value());
    }

    public function testDivideBy()
    {
        $division = Number::of(9)->divideBy(Number::of(3));
        $number = $division->divideBy(Number::of(3));

        $this->assertSame(1, $number->value());
    }

    public function testMulitplyBy()
    {
        $division = Number::of(4)->divideBy(Number::of(2));
        $number = $division->multiplyBy(Number::of(2));

        $this->assertSame(4, $number->value());
    }

    public function testFloor()
    {
        $division = Number::of(6.66)->divideBy(Number::of(3));
        $number = $division->floor();

        $this->assertSame(2.0, $number->value());
    }

    public function testCeil()
    {
        $division = Number::of(6.66)->divideBy(Number::of(3));
        $number = $division->ceil();

        $this->assertSame(3.0, $number->value());
    }

    public function testModulo()
    {
        $division = Number::of(9)->divideBy(Number::of(3));
        $number = $division->modulo(Number::of(2));

        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $division = Number::of(9)->divideBy(Number::of(-3));
        $number = $division->absolute();

        $this->assertSame(3, $number->value());
    }

    public function testPower()
    {
        $division = Number::of(9)->divideBy(Number::of(3));
        $number = $division->power(Number::of(2));

        $this->assertSame(9, $number->value());
    }

    public function testSquareRoot()
    {
        $division = Number::of(8)->divideBy(Number::of(2));
        $number = $division->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(8)->divideBy(Number::of(2))->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(8)->divideBy(Number::of(2))->signum();

        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '(2 + 2) ÷ 2',
            Number::of(2)
                ->add(Number::of(2))
                ->divideBy(Number::of(2))
                ->toString(),
        );
    }

    public function testThrowWhenTryingToDivideByZero()
    {
        $this->expectException(DivisionByZero::class);

        Number::of(4)->divideBy(Number::of(-0.0));
    }
}
