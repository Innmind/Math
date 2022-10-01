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
    Signum,
    Real,
};
use PHPUnit\Framework\TestCase;

class ETest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(Number::class, Value::e);
    }

    public function testStringCast()
    {
        $this->assertSame('e', Value::e->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Value::e->equals(Real::of(\M_E)));
        $this->assertFalse(Value::e->equals(Real::of(2.718)));
    }

    public function testHigherThan()
    {
        $this->assertTrue(Value::e->higherThan(Real::of(2.718)));
        $this->assertFalse(Value::e->higherThan(Real::of(\M_E)));
    }

    public function testAdd()
    {
        $number = Value::e;
        $number = $number->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(68.71828182845904, $number->value());
    }

    public function testSubtract()
    {
        $number = Value::e;
        $number = $number->subtract(Real::of(2));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(0.7182818284590451, $number->value());
    }

    public function testDivideBy()
    {
        $number = Value::e;
        $number = $number->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(\M_E / 2, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Value::e;
        $number = $number->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(\M_E * 2, $number->value());
    }

    public function testRound()
    {
        $number = Value::e;

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $number = Value::e;
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testCeil()
    {
        $number = Value::e;
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testModulo()
    {
        $number = Value::e;
        $number = $number->modulo(Real::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.7182818284590451, $number->value());
    }

    public function testAbsolute()
    {
        $number = Value::e;
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(\M_E, $number->value());
    }

    public function testPower()
    {
        $number = Value::e;
        $number = $number->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertEqualsWithDelta(\exp(2), $number->value(), 0.00000000000001);
        $this->assertSame(7.3890560989306495, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Value::e;
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(\sqrt(\M_E), $number->value());
    }

    public function testExponential()
    {
        $number = Value::e->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(\M_E), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Value::e->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\M_E, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Value::e->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\M_E), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Value::e->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\M_E), $number->value());
    }

    public function testSignum()
    {
        $number = Value::e->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
