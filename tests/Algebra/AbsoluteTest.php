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
        $absolute = Absolute::of(Number\Number::of(42.42));

        $this->assertInstanceOf(Number::class, $absolute);
        $this->assertInstanceOf(Operation::class, $absolute);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $absolute = Absolute::of(Number\Number::of($number));

        $this->assertSame($expected, $absolute->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '|42.45|',
            Absolute::of(Number\Number::of(42.45))->toString(),
        );
    }

    public function testEquals()
    {
        $absolute = Absolute::of(Number\Number::of(-42.45));

        $this->assertTrue($absolute->equals(Number\Number::of(42.45)));
        $this->assertFalse($absolute->equals(Number\Number::of(-42.45)));
    }

    public function testHigherThan()
    {
        $absolute = Absolute::of(Number\Number::of(-42.45));

        $this->assertTrue($absolute->higherThan(Number\Number::of(0)));
        $this->assertFalse($absolute->higherThan(Number\Number::of(43)));
    }

    public function testAdd()
    {
        $absolute = Absolute::of(Number\Number::of(-43));
        $number = $absolute->add(Number\Number::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50, $number->value());
    }

    public function testSubtract()
    {
        $absolute = Absolute::of(Number\Number::of(-43));
        $number = $absolute->subtract(Number\Number::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testMultiplication()
    {
        $absolute = Absolute::of(Number\Number::of(-43));
        $number = $absolute->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86, $number->value());
    }

    public function testDivision()
    {
        $absolute = Absolute::of(Number\Number::of(-43));
        $number = $absolute->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $number = Absolute::of(Number\Number::of(-42.45));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $absolute = Absolute::of(Number\Number::of(-42.45));
        $number = $absolute->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $absolute = Absolute::of(Number\Number::of(-42.45));
        $number = $absolute->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testAbsolute()
    {
        $absolute = Absolute::of(Number\Number::of(-42.45));
        $number = $absolute->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.45, $number->value());
    }

    public function testModulo()
    {
        $absolute = Absolute::of(Number\Number::of(-42.45));
        $number = $absolute->modulo(Number\Number::of(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertEqualsWithDelta(0.45, $number->value(), 0.001);
    }

    public function testPower()
    {
        $absolute = Absolute::of(Number\Number::of(-4));
        $number = $absolute->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $absolute = Absolute::of(Number\Number::of(-4));
        $number = $absolute->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Absolute::of(Number\Number::of(-4))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Absolute::of(Number\Number::of(-4))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Absolute::of(Number\Number::of(-4))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Absolute::of(Number\Number::of(-4))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Absolute::of(Number\Number::of(-4))->signum();

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
