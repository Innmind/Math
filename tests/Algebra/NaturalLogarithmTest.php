<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Logarithm,
    Algebra\Number,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NaturalLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $ln = Number::of(42.42)->apply(Logarithm::natural);

        $this->assertInstanceOf(Number::class, $ln);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        $_ = Number::of(0)->apply(Logarithm::natural)->memoize();
    }

    public function testResult()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);

        $this->assertSame(0, $ln->value());
    }

    public function testValue()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);

        $this->assertSame(0, $ln->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'ln(4)',
            Number::of(4)->apply(Logarithm::natural)->toString(),
        );
    }

    public function testEquals()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);

        $this->assertTrue($ln->equals(Number::of(0)));
        $this->assertFalse($ln->equals(Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);

        $this->assertTrue($ln->higherThan(Number::of(-0.1)));
        $this->assertFalse($ln->higherThan(Number::of(0)));
    }

    public function testAdd()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->add(Number::of(7));

        $this->assertSame(7, $number->value());
    }

    public function testSubtract()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->subtract(Number::of(7));

        $this->assertSame(-7, $number->value());
    }

    public function testMultiplication()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->multiplyBy(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testDivision()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->divideBy(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testFloor()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->floor();

        $this->assertSame(0, $number->value());
    }

    public function testCeil()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->ceil();

        $this->assertSame(0, $number->value());
    }

    public function testAbsolute()
    {
        $ln = Number::of(0.5)->apply(Logarithm::natural);
        $number = $ln->absolute();

        $this->assertSame(0.6931471805599453, $number->value());
    }

    public function testModulo()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->modulo(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testPower()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->power(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testSquareRoot()
    {
        $ln = Number::of(1)->apply(Logarithm::natural);
        $number = $ln->squareRoot();

        $this->assertSame(0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(1)->apply(Logarithm::natural)->exponential();

        $this->assertSame(1, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::natural)->apply(Logarithm::base2);

        $this->assertSame(\log(\log(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::natural)->apply(Logarithm::baseE);

        $this->assertSame(\log(\log(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::natural)->apply(Logarithm::base10);

        $this->assertSame(\log10(\log(2)), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->apply(Logarithm::natural)->signum();

        $this->assertSame(1, $number->value());
    }

    public function testLogarithmMultiplication()
    {
        //ln(axb) === ln(a) + ln(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(4))
                ->apply(Logarithm::natural)
                ->equals(
                    $a->apply(Logarithm::natural)->add(
                        $b->apply(Logarithm::natural),
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
                ->apply(Logarithm::natural)
                ->equals(
                    $a->apply(Logarithm::natural)->subtract(
                        $b->apply(Logarithm::natural),
                    ),
                ),
        );
    }
}
