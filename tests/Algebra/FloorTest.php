<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Floor,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
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

class FloorTest extends TestCase
{
    public function testInterface()
    {
        $floor = new Floor(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $floor);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $floor = new Floor(new Number\Number($number));

        $this->assertSame($expected, $floor->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '42.0',
            (new Floor(new Number\Number(42.45)))->toString(),
        );
    }

    public function testEquals()
    {
        $floor = new Floor(new Number\Number(42.45));

        $this->assertTrue($floor->equals(new Number\Number(42)));
        $this->assertTrue($floor->equals(new Number\Number(42.0)));
        $this->assertFalse($floor->equals(new Number\Number(43)));
    }

    public function testHigherThan()
    {
        $floor = new Floor(new Number\Number(42.45));

        $this->assertTrue($floor->higherThan(new Number\Number(41.9)));
        $this->assertFalse($floor->higherThan(new Number\Number(42.5)));
    }

    public function testAdd()
    {
        $floor = new Floor(new Number\Number(42.5));
        $number = $floor->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(49.0, $number->value());
    }

    public function testSubtract()
    {
        $floor = new Floor(new Number\Number(42.5));
        $number = $floor->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(35.0, $number->value());
    }

    public function testMultiplication()
    {
        $floor = new Floor(new Number\Number(42.5));
        $number = $floor->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testDivision()
    {
        $floor = new Floor(new Number\Number(42.5));
        $number = $floor->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testRound()
    {
        $number = new Floor(new Number\Number(42.45));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $floor = new Floor(new Number\Number(42.45));
        $number = $floor->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $floor = new Floor(new Number\Number(42.45));
        $number = $floor->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $floor = new Floor(new Number\Number(42.45));
        $number = $floor->modulo(new Number\Number(20));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $floor = new Floor(new Number\Number(-42.45));
        $number = $floor->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testPower()
    {
        $floor = new Floor(new Number\Number(2.5));
        $number = $floor->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testSquareRoot()
    {
        $floor = new Floor(new Number\Number(4.5));
        $number = $floor->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Floor(new Number\Number(4.5)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Floor(new Number\Number(3.5)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(3, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Floor(new Number\Number(3.5)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(3), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Floor(new Number\Number(3.5)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(3), $number->value());
    }

    public function testSignum()
    {
        $number = (new Floor(new Number\Number(2)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function values(): array
    {
        return [
            [42.4, 42.0],
            [42.5, 42.0],
            [42.6, 42.0],
            [42.51, 42.0],
        ];
    }
}
