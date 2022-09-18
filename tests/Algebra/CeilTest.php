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
        $ceil = Ceil::of(Number\Number::of(42.42));

        $this->assertInstanceOf(Number::class, $ceil);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $ceil = Ceil::of(Number\Number::of($number));

        $this->assertSame($expected, $ceil->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '43.0',
            (Ceil::of(Number\Number::of(42.45)))->toString(),
        );
    }

    public function testEquals()
    {
        $ceil = Ceil::of(Number\Number::of(42.45));

        $this->assertTrue($ceil->equals(Number\Number::of(43)));
        $this->assertTrue($ceil->equals(Number\Number::of(43.0)));
        $this->assertFalse($ceil->equals(Number\Number::of(42)));
    }

    public function testHigherThan()
    {
        $ceil = Ceil::of(Number\Number::of(42.45));

        $this->assertTrue($ceil->higherThan(Number\Number::of(41.9)));
        $this->assertFalse($ceil->higherThan(Number\Number::of(43.5)));
    }

    public function testAdd()
    {
        $ceil = Ceil::of(Number\Number::of(42.5));
        $number = $ceil->add(Number\Number::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $ceil = Ceil::of(Number\Number::of(42.5));
        $number = $ceil->subtract(Number\Number::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $ceil = Ceil::of(Number\Number::of(42.5));
        $number = $ceil->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $ceil = Ceil::of(Number\Number::of(42.5));
        $number = $ceil->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $number = Ceil::of(Number\Number::of(42.45));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $ceil = Ceil::of(Number\Number::of(42.45));
        $number = $ceil->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testCeil()
    {
        $ceil = Ceil::of(Number\Number::of(42.45));
        $number = $ceil->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $ceil = Ceil::of(Number\Number::of(42.45));
        $number = $ceil->modulo(Number\Number::of(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertEqualsWithDelta(1.0, $number->value(), 0.0001);
    }

    public function testAbsolute()
    {
        $ceil = Ceil::of(Number\Number::of(-42.45));
        $number = $ceil->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $ceil = Ceil::of(Number\Number::of(2.5));
        $number = $ceil->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ceil = Ceil::of(Number\Number::of(3.5));
        $number = $ceil->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Ceil::of(Number\Number::of(3.5))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Ceil::of(Number\Number::of(3.5))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Ceil::of(Number\Number::of(3.5))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Ceil::of(Number\Number::of(3.5))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Ceil::of(Number\Number::of(2))->signum();

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
