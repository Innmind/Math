<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    Value,
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

class PiTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Value::pi);
    }

    public function testStringCast()
    {
        $this->assertSame('π', Value::pi->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Value::pi->equals(Number\Number::of(3.141592653589793)));
        $this->assertFalse(Value::pi->equals(Number\Number::of(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue(Value::pi->higherThan(Number\Number::of(3.14)));
        $this->assertFalse(Value::pi->higherThan(Number\Number::of(3.15)));
    }

    public function testAdd()
    {
        $number = Value::pi;
        $number = $number->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(69.1415926535898, $number->value());
    }

    public function testSubtract()
    {
        $number = Value::pi;
        $number = $number->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62.8584073464102, $number->value());
    }

    public function testDivideBy()
    {
        $number = Value::pi;
        $number = $number->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(\M_PI_2, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Value::pi;
        $number = $number->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(\pi() * 2, $number->value());
    }

    public function testRound()
    {
        $number = Value::pi;

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $number = Value::pi;
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testCeil()
    {
        $number = Value::pi;
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $number = Value::pi;
        $number = $number->modulo(Number\Number::of(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.041592653589792944, $number->value());
    }

    public function testAbsolute()
    {
        $number = Value::pi;
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(Value::pi->value(), $number->value());
    }

    public function testPower()
    {
        $number = Value::pi;
        $number = $number->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(
            Value::pi->multiplyBy(Value::pi)->value(),
            $number->value(),
        );
    }

    public function testSquareRoot()
    {
        $number = Value::pi;
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertEqualsWithDelta(\M_SQRTPI, $number->value(), 0.000000000000001);
        $this->assertSame(1.7724538509055159, $number->value());
    }

    public function testExponential()
    {
        $number = Value::pi->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(\M_PI), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Value::pi->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\M_PI, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Value::pi->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\M_PI), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Value::pi->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\M_PI), $number->value());
    }

    public function testSignum()
    {
        $number = Value::pi->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
