<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\CommonLogarithm,
    Algebra\Number,
    DefinitionSet\Set,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CommonLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lg = Number::of(42.42)->commonLogarithm();

        $this->assertInstanceOf(Number::class, $lg);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::of(0)->commonLogarithm();
    }

    public function testResult()
    {
        $lg = Number::of(1)->commonLogarithm();

        $this->assertSame(0.0, $lg->value());
    }

    public function testValue()
    {
        $lg = Number::of(1)->commonLogarithm();

        $this->assertSame(0.0, $lg->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lg(4)',
            Number::of(4)->commonLogarithm()->toString(),
        );
    }

    public function testEquals()
    {
        $lg = Number::of(1)->commonLogarithm();

        $this->assertTrue($lg->equals(Number::of(0)));
        $this->assertFalse($lg->equals(Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $lg = Number::of(1)->commonLogarithm();

        $this->assertTrue($lg->higherThan(Number::of(-0.1)));
        $this->assertFalse($lg->higherThan(Number::of(0)));
    }

    public function testAdd()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->add(Number::of(7));

        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->subtract(Number::of(7));

        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->multiplyBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->divideBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->ceil();

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lg = Number::of(0.5)->commonLogarithm();
        $number = $lg->absolute();

        $this->assertSame(0.3010299956639812, $number->value());
    }

    public function testModulo()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->modulo(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->power(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lg = Number::of(1)->commonLogarithm();
        $number = $lg->squareRoot();

        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(1)->commonLogarithm()->exponential();

        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)->commonLogarithm()->binaryLogarithm();

        $this->assertSame(\log(\log10(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)->commonLogarithm()->naturalLogarithm();

        $this->assertSame(\log(\log10(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)->commonLogarithm()->commonLogarithm();

        $this->assertSame(\log10(\log10(2)), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->commonLogarithm()->signum();

        $this->assertSame(1, $number->value());
    }

    public function testDefinitionSet()
    {
        $set = CommonLogarithm::definitionSet();

        $this->assertInstanceOf(Set::class, $set);
        $this->assertSame(']0;+∞[', $set->toString());
    }

    public function testLogarithmMultiplication()
    {
        //lg(axb) === lg(a) + lg(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(4))
                ->commonLogarithm()
                ->equals(
                    $a->commonLogarithm()->add(
                        $b->commonLogarithm(),
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
                ->commonLogarithm()
                ->equals(
                    $a->commonLogarithm()->subtract(
                        $b->commonLogarithm(),
                    ),
                ),
        );
    }
}
