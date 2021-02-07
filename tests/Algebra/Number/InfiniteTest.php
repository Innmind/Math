<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\{
    Algebra\Number\Infinite,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
    Algebra\Floor,
    Algebra\Ceil,
    Algebra\Modulo,
    Algebra\Absolute,
    Algebra\Power,
    Algebra\SquareRoot,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    Exception\NotANumber,
    Exception\OutOfDefinitionSet
};
use PHPUnit\Framework\TestCase;

class InfiniteTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Infinite::positive());
    }

    public function testStringCast()
    {
        $this->assertSame('+∞', Infinite::positive()->toString());
        $this->assertSame('-∞', Infinite::negative()->toString());
    }

    public function testEquals()
    {
        $this->assertTrue((Infinite::positive())->equals(Infinite::positive()));
        $this->assertFalse((Infinite::positive())->equals(new Number\Number(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue((Infinite::positive())->higherThan(new Number\Number(3.14)));
        $this->assertFalse((Infinite::positive())->higherThan(Infinite::positive()));
    }

    public function testAdd()
    {
        $number = Infinite::positive();
        $number = $number->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testSubtract()
    {
        $number = Infinite::positive();
        $number = $number->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testDivideBy()
    {
        $number = Infinite::positive();
        $number = $number->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Infinite::positive();
        $number = $number->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testRound()
    {
        $number = Infinite::positive();

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $number = Infinite::positive();
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testCeil()
    {
        $number = Infinite::positive();
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testModulo()
    {
        $number = Infinite::positive();

        $this->expectException(NotANumber::class);

        $number->modulo(new Number\Number(1))->value();
    }

    public function testAbsolute()
    {
        $number = Infinite::negative();
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testPower()
    {
        $number = Infinite::positive();
        $number = $number->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Infinite::positive();
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testExponential()
    {
        $number = Infinite::positive()->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Infinite::positive()->binaryLogarithm();
    }

    public function testNaturalLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Infinite::positive()->naturalLogarithm();
    }

    public function testCommonLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Infinite::positive()->commonLogarithm();
    }

    public function testSignum()
    {
        $number = Infinite::positive()->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
