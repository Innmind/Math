<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExponentialTest extends TestCase
{
    public function testInterface()
    {
        $power = Number::zero()->exponential();

        $this->assertInstanceOf(Number::class, $power);
    }

    public function testResult()
    {
        $power = Number::of(2.1)->exponential();

        $this->assertSame(8.166169912567652, $power->value());
    }

    public function testStringCast()
    {
        $power = Number::of(2.1)->exponential();

        $this->assertSame('e^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = Number::of(2)
            ->add(Number::of(2))
            ->exponential();

        $this->assertSame('e^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = Number::of(2.1)->exponential();

        $this->assertTrue($power->equals(Number::of(8.166169912567652)));
        $this->assertFalse($power->equals(Number::of(8.16)));
    }

    public function testHigherThan()
    {
        $power = Number::of(2.1)->exponential();

        $this->assertTrue($power->higherThan(Number::of(8.16)));
        $this->assertFalse($power->higherThan(Number::of(8.166169912567652)));
    }

    public function testAdd()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->add(Number::of(66));

        $this->assertSame(74.16616991256765, $number->value());
    }

    public function testSubtract()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->subtract(Number::of(66));

        $this->assertSame(-57.83383008743235, $number->value());
    }

    public function testDivideBy()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->divideBy(Number::of(2));

        $this->assertSame(4.083084956283826, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->multiplyBy(Number::of(2));

        $this->assertSame(16.332339825135303, $number->value());
    }

    public function testFloor()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->floor();

        $this->assertSame(8.0, $number->value());
    }

    public function testCeil()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->ceil();

        $this->assertSame(9.0, $number->value());
    }

    public function testModulo()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->modulo(Number::of(8));

        $this->assertSame(0.16616991256765168, $number->value());
    }

    public function testAbsolute()
    {
        $power = Number::of(-2.1)->exponential();
        $number = $power->absolute();

        $this->assertSame(0.1224564282529819, $number->value());
    }

    public function testPower()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->power(Number::of(2));

        $this->assertSame(66.68633104092517, $number->value());
    }

    public function testSquareRoot()
    {
        $power = Number::of(2.1)->exponential();
        $number = $power->squareRoot();

        $this->assertSame(2.857651118063164, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(0)->exponential()->exponential();

        $this->assertSame(\exp(1), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(1)->exponential()->binaryLogarithm();

        $this->assertSame(\log(\exp(1), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(1)->exponential()->naturalLogarithm();

        $this->assertSame(\log(\exp(1)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(1)->exponential()->commonLogarithm();

        $this->assertSame(\log10(\exp(1)), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(1)->exponential()->signum();

        $this->assertSame(1, $number->value());
    }
}
