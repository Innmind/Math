<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    Number\Infinite,
    NumberInterface,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum
};
use PHPUnit\Framework\TestCase;

class InfiniteTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(NumberInterface::class, Infinite::positive());
    }

    public function testStringCast()
    {
        $this->assertSame('+∞', (string) Infinite::positive());
        $this->assertSame('-∞', (string) Infinite::negative());
    }

    public function testEquals()
    {
        $this->assertTrue((Infinite::positive())->equals(Infinite::positive()));
        $this->assertFalse((Infinite::positive())->equals(new Number(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue((Infinite::positive())->higherThan(new Number(3.14)));
        $this->assertFalse((Infinite::positive())->higherThan(Infinite::positive()));
    }

    public function testAdd()
    {
        $number = Infinite::positive();
        $number = $number->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testSubtract()
    {
        $number = Infinite::positive();
        $number = $number->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testDivideBy()
    {
        $number = Infinite::positive();
        $number = $number->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Infinite::positive();
        $number = $number->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testRound()
    {
        $number = Infinite::positive();
        $number = $number->round(2);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testFloor()
    {
        $number = Infinite::positive();
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testCeil()
    {
        $number = Infinite::positive();
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(INF, $number->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\NotANumber
     */
    public function testModulo()
    {
        $number = Infinite::positive();
        $number->modulo(new Number(1))->value();
    }

    public function testAbsolute()
    {
        $number = Infinite::negative();
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testPower()
    {
        $number = Infinite::positive();
        $number = $number->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Infinite::positive();
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(INF, $number->value());
    }

    public function testExponential()
    {
        $number = Infinite::positive()->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(INF, $number->value());
    }

    /**
     * @expectedException Innmind\Math\Exception\OutOfDefinitionSet
     */
    public function testBinaryLogarithm()
    {
        Infinite::positive()->binaryLogarithm();
    }

    /**
     * @expectedException Innmind\Math\Exception\OutOfDefinitionSet
     */
    public function testNaturalLogarithm()
    {
        Infinite::positive()->naturalLogarithm();
    }

    /**
     * @expectedException Innmind\Math\Exception\OutOfDefinitionSet
     */
    public function testCommonLogarithm()
    {
        Infinite::positive()->commonLogarithm();
    }

    public function testSignum()
    {
        $number = Infinite::positive()->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
