<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Logarithm,
    Algebra\Number,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CommonLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lg = Number::of(42.42)->apply(Logarithm::common);

        $this->assertInstanceOf(Number::class, $lg);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::of(0)->apply(Logarithm::common)->memoize();
    }

    public function testResult()
    {
        $lg = Number::of(1)->apply(Logarithm::common);

        $this->assertSame(0.0, $lg->value());
    }

    public function testValue()
    {
        $lg = Number::of(1)->apply(Logarithm::common);

        $this->assertSame(0.0, $lg->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lg(4)',
            Number::of(4)->apply(Logarithm::common)->toString(),
        );
    }

    public function testEquals()
    {
        $lg = Number::of(1)->apply(Logarithm::common);

        $this->assertTrue($lg->equals(Number::of(0)));
        $this->assertFalse($lg->equals(Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $lg = Number::of(1)->apply(Logarithm::common);

        $this->assertTrue($lg->higherThan(Number::of(-0.1)));
        $this->assertFalse($lg->higherThan(Number::of(0)));
    }

    public function testAdd()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->add(Number::of(7));

        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->subtract(Number::of(7));

        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->multiplyBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->divideBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->ceil();

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lg = Number::of(0.5)->apply(Logarithm::common);
        $number = $lg->absolute();

        $this->assertSame(0.3010299956639812, $number->value());
    }

    public function testModulo()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->modulo(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->power(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lg = Number::of(1)->apply(Logarithm::common);
        $number = $lg->squareRoot();

        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(1)->apply(Logarithm::common)->exponential();

        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::common)->apply(Logarithm::base2);

        $this->assertSame(\log(\log10(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::common)->apply(Logarithm::baseE);

        $this->assertSame(\log(\log10(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::common)->apply(Logarithm::base10);

        $this->assertSame(\log10(\log10(2)), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->apply(Logarithm::common)->signum();

        $this->assertSame(1, $number->value());
    }

    public function testLogarithmMultiplication()
    {
        //lg(axb) === lg(a) + lg(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(4))
                ->apply(Logarithm::common)
                ->equals(
                    $a->apply(Logarithm::common)->add(
                        $b->apply(Logarithm::common),
                    ),
                ),
        );
    }

    public function testLogarithmDivision()
    {
        //lg(a/b) === lg(a) - lg(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->divideBy($b = Number::of(4))
                ->apply(Logarithm::common)
                ->equals(
                    $a->apply(Logarithm::common)->subtract(
                        $b->apply(Logarithm::common),
                    ),
                ),
        );
    }
}
