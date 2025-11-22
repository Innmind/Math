<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\NaturalLogarithm,
    Algebra\Number,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NaturalLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $ln = Number::of(42.42)->naturalLogarithm();

        $this->assertInstanceOf(Number::class, $ln);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::of(0)->naturalLogarithm();
    }

    public function testResult()
    {
        $ln = Number::of(1)->naturalLogarithm();

        $this->assertSame(0.0, $ln->value());
    }

    public function testValue()
    {
        $ln = Number::of(1)->naturalLogarithm();

        $this->assertSame(0.0, $ln->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'ln(4)',
            Number::of(4)->naturalLogarithm()->toString(),
        );
    }

    public function testEquals()
    {
        $ln = Number::of(1)->naturalLogarithm();

        $this->assertTrue($ln->equals(Number::of(0)));
        $this->assertFalse($ln->equals(Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $ln = Number::of(1)->naturalLogarithm();

        $this->assertTrue($ln->higherThan(Number::of(-0.1)));
        $this->assertFalse($ln->higherThan(Number::of(0)));
    }

    public function testAdd()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->add(Number::of(7));

        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->subtract(Number::of(7));

        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->multiplyBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->divideBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->ceil();

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $ln = Number::of(0.5)->naturalLogarithm();
        $number = $ln->absolute();

        $this->assertSame(0.6931471805599453, $number->value());
    }

    public function testModulo()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->modulo(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->power(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ln = Number::of(1)->naturalLogarithm();
        $number = $ln->squareRoot();

        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(1)->naturalLogarithm()->exponential();

        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)->naturalLogarithm()->binaryLogarithm();

        $this->assertSame(\log(\log(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)->naturalLogarithm()->naturalLogarithm();

        $this->assertSame(\log(\log(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)->naturalLogarithm()->commonLogarithm();

        $this->assertSame(\log10(\log(2)), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->naturalLogarithm()->signum();

        $this->assertSame(1, $number->value());
    }

    public function testDefinitionSet()
    {
        $set = NaturalLogarithm::definitionSet();

        $this->assertSame(']0;+∞[', $set->toString());
    }

    public function testLogarithmMultiplication()
    {
        //ln(axb) === ln(a) + ln(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(4))
                ->naturalLogarithm()
                ->equals(
                    $a->naturalLogarithm()->add(
                        $b->naturalLogarithm(),
                    ),
                ),
        );
    }

    public function testLogarithmDivision()
    {
        //ln(a/b) === ln(a) - ln(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->divideBy($b = Number::of(4))
                ->naturalLogarithm()
                ->equals(
                    $a->naturalLogarithm()->subtract(
                        $b->naturalLogarithm(),
                    ),
                ),
        );
    }
}
