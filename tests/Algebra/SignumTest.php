<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SignumTest extends TestCase
{
    public function testInterface()
    {
        $sgn = Number::one()->signum();

        $this->assertInstanceOf(Number::class, $sgn);
    }

    public function testResult()
    {
        $sgn = Number::of(42)->signum();

        $this->assertSame(1, $sgn->value());

        $this->assertSame(-1, Number::of(-42)->signum()->value());
        $this->assertSame(0, Number::of(0)->signum()->value());
    }

    public function testStringCast()
    {
        $sgn = Number::of(42.24)->signum();

        $this->assertSame('sgn(42.24)', $sgn->toString());
    }

    public function testStringCastOperations()
    {
        $sgn = Number::of(1)
            ->add(Number::of(1))
            ->signum();

        $this->assertSame('sgn(1 + 1)', $sgn->toString());
    }

    public function testEquals()
    {
        $sgn = Number::of(2)->signum();

        $this->assertTrue($sgn->equals(Number::of(1)));
        $this->assertFalse($sgn->equals(Number::of(0)));
    }

    public function testHigherThan()
    {
        $sgn = Number::of(2)->signum();

        $this->assertTrue($sgn->higherThan(Number::of(0)));
        $this->assertFalse($sgn->higherThan(Number::of(1)));
    }

    public function testAdd()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->add(Number::of(66));

        $this->assertSame(67, $number->value());
    }

    public function testSubtract()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->subtract(Number::of(66));

        $this->assertSame(-65, $number->value());
    }

    public function testDivideBy()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->divideBy(Number::of(2));

        $this->assertSame(0.5, $number->value());
    }

    public function testMulitplyBy()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->multiplyBy(Number::of(2));

        $this->assertSame(2, $number->value());
    }

    public function testFloor()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->floor();

        $this->assertSame(1.0, $number->value());
    }

    public function testCeil()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->ceil();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->modulo(Number::of(0.5));

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $sgn = Number::of(-2)->signum();
        $number = $sgn->absolute();

        $this->assertSame(1, $number->value());
    }

    public function testPower()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->power(Number::of(2));

        $this->assertSame(1, $number->value());
    }

    public function testSquareRoot()
    {
        $sgn = Number::of(2)->signum();
        $number = $sgn->squareRoot();

        $this->assertSame(1.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(2)
            ->signum()
            ->exponential();

        $this->assertSame(\exp(1), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)
            ->signum()
            ->binaryLogarithm();

        $this->assertSame(\log(1, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)
            ->signum()
            ->naturalLogarithm();

        $this->assertSame(\log(1), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)
            ->signum()
            ->commonLogarithm();

        $this->assertSame(\log10(1), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(1)->signum()->signum();

        $this->assertSame(1, $number->value());
    }
}
