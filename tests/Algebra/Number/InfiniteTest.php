<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Logarithm,
    Exception\NotANumber,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class InfiniteTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Number::infinite());
    }

    public function testStringCast()
    {
        $this->assertSame('+∞', Number::infinite()->toString());
        $this->assertSame('-∞', Number::negativeInfinite()->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Number::infinite()->equals(Number::infinite()));
        $this->assertFalse(Number::infinite()->equals(Number::of(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue((Number::infinite())->higherThan(Number::of(3.14)));
        $this->assertFalse((Number::infinite())->higherThan(Number::infinite()));
    }

    public function testAdd()
    {
        $number = Number::infinite();
        $number = $number->add(Number::of(66));

        $this->assertSame(\INF, $number->value());
    }

    public function testSubtract()
    {
        $number = Number::infinite();
        $number = $number->subtract(Number::of(66));

        $this->assertSame(\INF, $number->value());
    }

    public function testDivideBy()
    {
        $number = Number::infinite();
        $number = $number->divideBy(Number::of(2));

        $this->assertSame(\INF, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Number::infinite();
        $number = $number->multiplyBy(Number::of(2));

        $this->assertSame(\INF, $number->value());
    }

    public function testFloor()
    {
        $number = Number::infinite();
        $number = $number->floor();

        $this->assertSame(\INF, $number->value());
    }

    public function testCeil()
    {
        $number = Number::infinite();

        $this->assertSame(\INF, $number->value());
    }

    public function testModulo()
    {
        $number = Number::infinite();

        $this->expectException(NotANumber::class);

        $number->modulo(Number::of(1))->value();
    }

    public function testAbsolute()
    {
        $number = Number::negativeInfinite();
        $number = $number->absolute();

        $this->assertSame(\INF, $number->value());
    }

    public function testPower()
    {
        $number = Number::infinite();
        $number = $number->power(Number::of(2));

        $this->assertSame(\INF, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Number::infinite();
        $number = $number->squareRoot();

        $this->assertSame(\INF, $number->value());
    }

    public function testExponential()
    {
        $number = Number::infinite()->exponential();

        $this->assertSame(\INF, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::infinite()->apply(Logarithm::base2)->memoize();
    }

    public function testNaturalLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::infinite()->apply(Logarithm::baseE)->memoize();
    }

    public function testCommonLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::infinite()->apply(Logarithm::base10)->memoize();
    }

    public function testSignum()
    {
        $number = Number::infinite()->signum();

        $this->assertSame(1, $number->value());
    }
}
