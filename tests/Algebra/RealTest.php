<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Real,
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
    Algebra\Integer,
    Algebra\Value,
    Algebra\Signum,
    Exception\NotANumber,
};
use PHPUnit\Framework\TestCase;

class RealTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Number::class,
            Real::of(42),
        );
    }

    public function testThrowWhenNotANumber()
    {
        $this->expectException(NotANumber::class);

        Real::of(\NAN);
    }

    public function testWrap()
    {
        $number = Real::of(42.1);

        $this->assertInstanceOf(Real::class, $number);
        $this->assertSame('42.1', $number->toString());

        $number = Real::of(42);

        $this->assertInstanceOf(Integer::class, $number);
        $this->assertSame('42', $number->toString());

        $number = Real::of(\INF);

        $this->assertSame(Value::infinite, $number);
        $this->assertSame('+∞', $number->toString());

        $number = Real::of(-\INF);

        $this->assertSame(Value::negativeInfinite, $number);
        $this->assertSame('-∞', $number->toString());
    }

    public function testInt()
    {
        $number = Real::of(42);

        $this->assertSame(42, $number->value());
        $this->assertSame('42', $number->toString());
    }

    public function testFloat()
    {
        $number = Real::of(42.24);

        $this->assertSame(42.24, $number->value());
        $this->assertSame('42.24', $number->toString());
    }

    public function testEquals()
    {
        $this->assertTrue((Real::of(42))->equals(Real::of(42)));
        $this->assertTrue((Real::of(42))->equals(Real::of(42.0)));
        $this->assertTrue((Real::of(42.0))->equals(Real::of(42)));
        $this->assertTrue(
            Real::of(42.1)->equals(Real::of(
                42.099999999999999, # with a precision over 14 digits php will round it
            )),
        );
        $this->assertFalse((Real::of(42))->equals(Real::of(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse(Real::of(42)->higherThan(Real::of(42)));
        $this->assertTrue(Real::of(42)->higherThan(Real::of(41.24)));
    }

    public function testAdd()
    {
        $number = Real::of(42);
        $number = $number->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(108, $number->value());
    }

    public function testSubtract()
    {
        $number = Real::of(42);
        $number = $number->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24, $number->value());
    }

    public function testDivideBy()
    {
        $number = Real::of(42);
        $number = $number->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Real::of(42);
        $number = $number->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testRound()
    {
        $number = Real::of(42.25);

        $this->assertEquals(Round::up($number, 1), $number->roundUp(1));
        $this->assertEquals(Round::down($number, 1), $number->roundDown(1));
        $this->assertEquals(Round::even($number, 1), $number->roundEven(1));
        $this->assertEquals(Round::odd($number, 1), $number->roundOdd(1));
    }

    public function testFloor()
    {
        $number = Real::of(42.25);
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $number = Real::of(42.25);
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $number = Real::of(3);
        $number = $number->modulo(Real::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $number = Real::of(-9);
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $number = Real::of(-9);
        $number = $number->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Real::of(4);
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Real::of(4)->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Real::of(4)->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Real::of(4)->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Real::of(4)->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Real::of(2)->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
