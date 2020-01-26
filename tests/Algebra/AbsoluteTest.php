<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Absolute,
    Ceil,
    Floor,
    Operation,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Modulo,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum
};
use PHPUnit\Framework\TestCase;

class AbsoluteTest extends TestCase
{
    public function testInterface()
    {
        $absolute = new Absolute(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $absolute);
        $this->assertInstanceOf(Operation::class, $absolute);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $absolute = new Absolute(new Number\Number($number));

        $this->assertSame($expected, $absolute->value());
        $this->assertSame($absolute->result(), $absolute->result());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '|42.45|',
            (new Absolute(new Number\Number(42.45)))->toString()
        );
    }

    public function testEquals()
    {
        $absolute = new Absolute(new Number\Number(-42.45));

        $this->assertTrue($absolute->equals(new Number\Number(42.45)));
        $this->assertFalse($absolute->equals(new Number\Number(-42.45)));
    }

    public function testHigherThan()
    {
        $absolute = new Absolute(new Number\Number(-42.45));

        $this->assertTrue($absolute->higherThan(new Number\Number(0)));
        $this->assertFalse($absolute->higherThan(new Number\Number(43)));
    }

    public function testAdd()
    {
        $absolute = new Absolute(new Number\Number(-43));
        $number = $absolute->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50, $number->value());
    }

    public function testSubtract()
    {
        $absolute = new Absolute(new Number\Number(-43));
        $number = $absolute->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testMultiplication()
    {
        $absolute = new Absolute(new Number\Number(-43));
        $number = $absolute->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86, $number->value());
    }

    public function testDivision()
    {
        $absolute = new Absolute(new Number\Number(-43));
        $number = $absolute->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $number = new Absolute(new Number\Number(-42.45));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $absolute = new Absolute(new Number\Number(-42.45));
        $number = $absolute->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $absolute = new Absolute(new Number\Number(-42.45));
        $number = $absolute->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testAbsolute()
    {
        $absolute = new Absolute(new Number\Number(-42.45));
        $number = $absolute->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.45, $number->value());
    }

    public function testModulo()
    {
        $absolute = new Absolute(new Number\Number(-42.45));
        $number = $absolute->modulo(new Number\Number(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.45, $number->value());
    }

    public function testPower()
    {
        $absolute = new Absolute(new Number\Number(-4));
        $number = $absolute->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $absolute = new Absolute(new Number\Number(-4));
        $number = $absolute->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Absolute(new Number\Number(-4)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Absolute(new Number\Number(-4)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Absolute(new Number\Number(-4)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Absolute(new Number\Number(-4)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Absolute(new Number\Number(-4)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function values(): array
    {
        return [
            [-1, 1],
            [1, 1],
        ];
    }
}
