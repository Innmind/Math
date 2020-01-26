<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Ceil,
    Floor,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
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

class CeilTest extends TestCase
{
    public function testInterface()
    {
        $ceil = new Ceil(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $ceil);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $ceil = new Ceil(new Number\Number($number));

        $this->assertSame($expected, $ceil->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '43.0',
            (new Ceil(new Number\Number(42.45)))->toString()
        );
    }

    public function testEquals()
    {
        $ceil = new Ceil(new Number\Number(42.45));

        $this->assertTrue($ceil->equals(new Number\Number(43)));
        $this->assertTrue($ceil->equals(new Number\Number(43.0)));
        $this->assertFalse($ceil->equals(new Number\Number(42)));
    }

    public function testHigherThan()
    {
        $ceil = new Ceil(new Number\Number(42.45));

        $this->assertTrue($ceil->higherThan(new Number\Number(41.9)));
        $this->assertFalse($ceil->higherThan(new Number\Number(43.5)));
    }

    public function testAdd()
    {
        $ceil = new Ceil(new Number\Number(42.5));
        $number = $ceil->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $ceil = new Ceil(new Number\Number(42.5));
        $number = $ceil->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $ceil = new Ceil(new Number\Number(42.5));
        $number = $ceil->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $ceil = new Ceil(new Number\Number(42.5));
        $number = $ceil->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $number = new Ceil(new Number\Number(42.45));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $ceil = new Ceil(new Number\Number(42.45));
        $number = $ceil->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testCeil()
    {
        $ceil = new Ceil(new Number\Number(42.45));
        $number = $ceil->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $ceil = new Ceil(new Number\Number(42.45));
        $number = $ceil->modulo(new Number\Number(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $ceil = new Ceil(new Number\Number(-42.45));
        $number = $ceil->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $ceil = new Ceil(new Number\Number(2.5));
        $number = $ceil->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ceil = new Ceil(new Number\Number(3.5));
        $number = $ceil->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Ceil(new Number\Number(3.5)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Ceil(new Number\Number(3.5)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Ceil(new Number\Number(3.5)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Ceil(new Number\Number(3.5)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Ceil(new Number\Number(2)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function values(): array
    {
        return [
            [42.4, 43.0],
            [42.5, 43.0],
            [42.6, 43.0],
            [42.51, 43.0],
        ];
    }
}
