<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Number,
    Exception\NotANumber,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RealTest extends TestCase
{
    public function testThrowWhenNotANumber()
    {
        $this->expectException(NotANumber::class);

        Number::of(\NAN);
    }

    public function testWrap()
    {
        $number = Number::of(42.1);

        $this->assertSame('42.1', $number->toString());

        $number = Number::of(42);

        $this->assertSame('42', $number->toString());

        $number = Number::of(\INF);

        $this->assertEquals(Number::infinite(), $number);
        $this->assertSame('+∞', $number->toString());

        $number = Number::of(-\INF);

        $this->assertEquals(Number::negativeInfinite(), $number);
        $this->assertSame('-∞', $number->toString());
    }

    public function testInt()
    {
        $number = Number::of(42);

        $this->assertSame(42, $number->value());
        $this->assertSame('42', $number->toString());
    }

    public function testFloat()
    {
        $number = Number::of(42.24);

        $this->assertSame(42.24, $number->value());
        $this->assertSame('42.24', $number->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Number::of(42)->equals(Number::of(42)));
        $this->assertTrue(Number::of(42)->equals(Number::of(42.0)));
        $this->assertTrue(Number::of(42.0)->equals(Number::of(42)));
        $this->assertTrue(
            Number::of(42.1)->equals(Number::of(
                42.099999999999999, # with a precision over 14 digits php will round it
            )),
        );
        $this->assertFalse(Number::of(42)->equals(Number::of(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse(Number::of(42)->higherThan(Number::of(42)));
        $this->assertTrue(Number::of(42)->higherThan(Number::of(41.24)));
    }

    public function testAdd()
    {
        $number = Number::of(42);
        $number = $number->add(Number::of(66));

        $this->assertSame(108, $number->value());
    }

    public function testSubtract()
    {
        $number = Number::of(42);
        $number = $number->subtract(Number::of(66));

        $this->assertSame(-24, $number->value());
    }

    public function testDivideBy()
    {
        $number = Number::of(42);
        $number = $number->divideBy(Number::of(2));

        $this->assertSame(21, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Number::of(42);
        $number = $number->multiplyBy(Number::of(2));

        $this->assertSame(84, $number->value());
    }

    public function testFloor()
    {
        $number = Number::of(42.25);
        $number = $number->floor();

        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $number = Number::of(42.25);
        $number = $number->ceil();

        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $number = Number::of(3);
        $number = $number->modulo(Number::of(2));

        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $number = Number::of(-9);
        $number = $number->absolute();

        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $number = Number::of(-9);
        $number = $number->power(Number::of(2));

        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Number::of(4);
        $number = $number->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(4)->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(4)->binaryLogarithm();

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(4)->naturalLogarithm();

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(4)->commonLogarithm();

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->signum();

        $this->assertSame(1, $number->value());
    }
}
