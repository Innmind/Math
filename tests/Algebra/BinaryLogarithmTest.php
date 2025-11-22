<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\BinaryLogarithm,
    Algebra\Number,
    DefinitionSet\Set,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class BinaryLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lb = Number::of(42.42)->binaryLogarithm();

        $this->assertInstanceOf(Number::class, $lb);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Number::of(0)->binaryLogarithm();
    }

    public function testResult()
    {
        $lb = Number::of(1)->binaryLogarithm();

        $this->assertSame(0.0, $lb->value());
    }

    public function testValue()
    {
        $lb = Number::of(1)->binaryLogarithm();

        $this->assertSame(0.0, $lb->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lb(4)',
            Number::of(4)->binaryLogarithm()->toString(),
        );
    }

    public function testEquals()
    {
        $lb = Number::of(1)->binaryLogarithm();

        $this->assertTrue($lb->equals(Number::of(0)));
        $this->assertFalse($lb->equals(Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $lb = Number::of(1)->binaryLogarithm();

        $this->assertTrue($lb->higherThan(Number::of(-0.1)));
        $this->assertFalse($lb->higherThan(Number::of(0)));
    }

    public function testAdd()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->add(Number::of(7));

        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->subtract(Number::of(7));

        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->multiplyBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->divideBy(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->ceil();

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lb = Number::of(0.5)->binaryLogarithm();
        $number = $lb->absolute();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->modulo(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->power(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lb = Number::of(1)->binaryLogarithm();
        $number = $lb->squareRoot();

        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(1)->binaryLogarithm()->exponential();

        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Number::of(2)->binaryLogarithm()->binaryLogarithm();

        $this->assertSame(\log(\log(2, 2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Number::of(2)->binaryLogarithm()->naturalLogarithm();

        $this->assertSame(\log(\log(2, 2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Number::of(2)->binaryLogarithm()->commonLogarithm();

        $this->assertSame(\log10(\log(2, 2)), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)->binaryLogarithm()->signum();

        $this->assertSame(1, $number->value());
    }

    public function testDefinitionSet()
    {
        $set = BinaryLogarithm::definitionSet();

        $this->assertInstanceOf(Set::class, $set);
        $this->assertSame(']0;+∞[', $set->toString());
    }

    public function testLogarithmMultiplication()
    {
        //lb(axb) === lb(a) + lb(b)
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(4))
                ->binaryLogarithm()
                ->equals(
                    $a->binaryLogarithm()->add(
                        $b->binaryLogarithm(),
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
                ->binaryLogarithm()
                ->equals(
                    $a->binaryLogarithm()->subtract(
                        $b->binaryLogarithm(),
                    ),
                ),
        );
    }
}
