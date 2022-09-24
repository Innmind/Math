<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\{
    Algebra\Value,
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
    Algebra\Real,
    Exception\NotANumber,
    Exception\OutOfDefinitionSet
};
use PHPUnit\Framework\TestCase;

class InfiniteTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Value::infinite);
    }

    public function testStringCast()
    {
        $this->assertSame('+∞', Value::infinite->toString());
        $this->assertSame('-∞', Value::negativeInfinite->toString());
    }

    public function testEquals()
    {
        $this->assertTrue((Value::infinite)->equals(Value::infinite));
        $this->assertFalse((Value::infinite)->equals(Real::of(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue((Value::infinite)->higherThan(Real::of(3.14)));
        $this->assertFalse((Value::infinite)->higherThan(Value::infinite));
    }

    public function testAdd()
    {
        $number = Value::infinite;
        $number = $number->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testSubtract()
    {
        $number = Value::infinite;
        $number = $number->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testDivideBy()
    {
        $number = Value::infinite;
        $number = $number->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Value::infinite;
        $number = $number->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testRound()
    {
        $number = Value::infinite;

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $number = Value::infinite;
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testCeil()
    {
        $number = Value::infinite;
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testModulo()
    {
        $number = Value::infinite;

        $this->expectException(NotANumber::class);

        $number->modulo(Real::of(1))->value();
    }

    public function testAbsolute()
    {
        $number = Value::negativeInfinite;
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testPower()
    {
        $number = Value::infinite;
        $number = $number->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Value::infinite;
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testExponential()
    {
        $number = Value::infinite->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\INF, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Value::infinite->binaryLogarithm();
    }

    public function testNaturalLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Value::infinite->naturalLogarithm();
    }

    public function testCommonLogarithm()
    {
        $this->expectException(OutOfDefinitionSet::class);

        Value::infinite->commonLogarithm();
    }

    public function testSignum()
    {
        $number = Value::infinite->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
