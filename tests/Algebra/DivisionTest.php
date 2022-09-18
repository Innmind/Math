<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Division,
    Algebra\Number,
    Algebra\Operation,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
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
    Exception\DivisionByZero,
};
use PHPUnit\Framework\TestCase;

class DivisionTest extends TestCase
{
    public function testInterface()
    {
        $division = Division::of(
            $dividend = Number\Number::of(4),
            $divisor = Number\Number::of(2),
        );

        $this->assertInstanceOf(Operation::class, $division);
        $this->assertInstanceOf(Number::class, $division);
        $this->assertSame($dividend, $division->dividend());
        $this->assertSame($divisor, $division->divisor());
    }

    public function testResult()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));
        $result = $division->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2, $result->value());
        $this->assertTrue($result->equals($division->quotient()));
    }

    public function testValue()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));

        $this->assertSame(2, $division->value());
    }

    public function testEquals()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));

        $this->assertTrue($division->equals(Number\Number::of(2)));
        $this->assertFalse($division->equals(Number\Number::of(2.1)));
    }

    public function testHigherThan()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));

        $this->assertFalse($division->higherThan(Number\Number::of(2)));
        $this->assertTrue($division->higherThan(Number\Number::of(1.9)));
    }

    public function testAdd()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));
        $number = $division->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(68, $number->value());
    }

    public function testSubtract()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));
        $number = $division->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-64, $number->value());
    }

    public function testDivideBy()
    {
        $division = Division::of(Number\Number::of(9), Number\Number::of(3));
        $number = $division->divideBy(Number\Number::of(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testMulitplyBy()
    {
        $division = Division::of(Number\Number::of(4), Number\Number::of(2));
        $number = $division->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(4, $number->value());
    }

    public function testRound()
    {
        $number = Division::of(Number\Number::of(6.66), Number\Number::of(3));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $division = Division::of(Number\Number::of(6.66), Number\Number::of(3));
        $number = $division->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testCeil()
    {
        $division = Division::of(Number\Number::of(6.66), Number\Number::of(3));
        $number = $division->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testModulo()
    {
        $division = Division::of(Number\Number::of(9), Number\Number::of(3));
        $number = $division->modulo(Number\Number::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $division = Division::of(Number\Number::of(9), Number\Number::of(-3));
        $number = $division->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(3, $number->value());
    }

    public function testPower()
    {
        $division = Division::of(Number\Number::of(9), Number\Number::of(3));
        $number = $division->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testSquareRoot()
    {
        $division = Division::of(Number\Number::of(8), Number\Number::of(2));
        $number = $division->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Division::of(Number\Number::of(8), Number\Number::of(2))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Division::of(Number\Number::of(8), Number\Number::of(2))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Division::of(Number\Number::of(8), Number\Number::of(2))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Division::of(Number\Number::of(8), Number\Number::of(2))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Division::of(Number\Number::of(8), Number\Number::of(2))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '(2 + 2) ÷ 2',
            Division::of(
                Addition::of(
                    Number\Number::of(2),
                    Number\Number::of(2),
                ),
                Number\Number::of(2),
            )->toString(),
        );
    }

    public function testThrowWhenTryingToDivideByZero()
    {
        $this->expectException(DivisionByZero::class);

        Division::of(Number\Number::of(4), Number\Number::of(-0.0));
    }
}
