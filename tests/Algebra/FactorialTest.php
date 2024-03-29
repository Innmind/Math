<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Factorial,
    Algebra\Integer,
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
    Exception\FactorialMustBePositive
};
use PHPUnit\Framework\TestCase;

class FactorialTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Number::class,
            Factorial::of(42),
        );
    }

    public function testThrowWhenNegativeFactorial()
    {
        $this->expectException(FactorialMustBePositive::class);

        Factorial::of(-1);
    }

    public function testStringCast()
    {
        $number = Factorial::of(3);

        $this->assertSame(6, $number->value());
        $this->assertSame('3!', $number->toString());
    }

    public function testEquals()
    {
        $this->assertTrue(Factorial::of(3)->equals(Factorial::of(3)));
        $this->assertTrue(Factorial::of(3)->equals(Real::of(6.0)));
        $this->assertFalse(Factorial::of(3)->equals(Real::of(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse(Factorial::of(3)->higherThan(Factorial::of(3)));
        $this->assertTrue(Factorial::of(3)->higherThan(Real::of(1.24)));
    }

    public function testAdd()
    {
        $number = Factorial::of(3);
        $number = $number->add(Integer::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(72, $number->value());
    }

    public function testSubtract()
    {
        $number = Factorial::of(3);
        $number = $number->subtract(Integer::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-60, $number->value());
    }

    public function testDivideBy()
    {
        $number = Factorial::of(3);
        $number = $number->divideBy(Integer::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = Factorial::of(3);
        $number = $number->multiplyBy(Integer::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(12, $number->value());
    }

    public function testRound()
    {
        $number = Factorial::of(3);

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $number = Factorial::of(3);
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $number = Factorial::of(3);
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testModulo()
    {
        $number = Factorial::of(3);
        $number = $number->modulo(Integer::of(4));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $number = Factorial::of(3);
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testPower()
    {
        $number = Factorial::of(3);
        $number = $number->power(Integer::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $number = Factorial::of(3);
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.449489742783178, $number->value());
    }

    public function testExponential()
    {
        $number = Factorial::of(4)->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(24), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Factorial::of(4)->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(24, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Factorial::of(4)->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(24), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Factorial::of(4)->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(24), $number->value());
    }

    public function testSignum()
    {
        $number = Factorial::of(4)->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    /**
     * @dataProvider factorials
     */
    public function testResult($integer, $expected)
    {
        $number = Factorial::of($integer);

        $this->assertInstanceOf(Number::class, $number->result());
        $this->assertSame($expected, $number->result()->value());
    }

    public function factorials(): array
    {
        return [
            [0, 1],
            [1, 1],
            [2, 2],
            [3, 6],
            [4, 24],
            [10, 3628800],
            [100, 9.332621544394418E+157],
        ];
    }
}
