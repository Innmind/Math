<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Logarithm,
    Algebra\Number,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class BinaryLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lb = Number::of(42.42)->apply(Logarithm::binary);

        $this->assertInstanceOf(Number::class, $lb);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        $_ = Number::of(0)->apply(Logarithm::binary)->memoize();
    }

    public function testResult()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);

        $this->assertSame(0, $lb->value());
    }

    public function testValue()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);

        $this->assertSame(0, $lb->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lb(4)',
            Number::of(4)->apply(Logarithm::binary)->toString(),
        );
    }

    public function testEquals()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);

        $this->assertTrue($lb->equals(Number::of(0)));
        $this->assertFalse($lb->equals(Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);

        $this->assertTrue($lb->higherThan(Number::of(-0.1)));
        $this->assertFalse($lb->higherThan(Number::of(0)));
    }

    public function testAdd()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->add(Number::of(7));

        $this->assertSame(7, $number->value());
    }

    public function testSubtract()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->subtract(Number::of(7));

        $this->assertSame(-7, $number->value());
    }

    public function testMultiplication()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->multiplyBy(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testDivision()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->divideBy(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testFloor()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->floor();

        $this->assertSame(0, $number->value());
    }

    public function testCeil()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->ceil();

        $this->assertSame(0, $number->value());
    }

    public function testAbsolute()
    {
        $lb = Number::of(0.5)->apply(Logarithm::binary);
        $number = $lb->absolute();

        $this->assertSame(1, $number->value());
    }

    public function testModulo()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->modulo(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testPower()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->power(Number::of(2));

        $this->assertSame(0, $number->value());
    }

    public function testSquareRoot()
    {
        $lb = Number::of(1)->apply(Logarithm::binary);
        $number = $lb->squareRoot();

        $this->assertSame(0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(1)->apply(Logarithm::binary)->exponential();

        $this->assertSame(1, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::binary)->apply(Logarithm::base2);

        $this->assertSame(0, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::binary)->apply(Logarithm::baseE);

        $this->assertSame(0, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)->apply(Logarithm::binary)->apply(Logarithm::base10);

        $this->assertSame(0, $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->apply(Logarithm::binary)->signum();

        $this->assertSame(1, $number->value());
    }

    public function testLogarithmMultiplication()
    {
        //lb(axb) === lb(a) + lb(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(4))
                ->apply(Logarithm::binary)
                ->equals(
                    $a->apply(Logarithm::binary)->add(
                        $b->apply(Logarithm::binary),
                    ),
                ),
        );
    }

    public function testLogarithmDivision()
    {
        //lb(a/b) === lb(a) - lb(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->divideBy($b = Number::of(4))
                ->apply(Logarithm::binary)
                ->equals(
                    $a->apply(Logarithm::binary)->subtract(
                        $b->apply(Logarithm::binary),
                    ),
                ),
        );
    }
}
