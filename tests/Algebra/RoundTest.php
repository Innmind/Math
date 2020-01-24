<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\Round,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
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
    Exception\PrecisionMustBePositive
};
use PHPUnit\Framework\TestCase;

class RoundTest extends TestCase
{
    public function testInterface()
    {
        $round = new Round(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $round);
    }

    public function testThrowWhenNegativePrecision()
    {
        $this->expectException(PrecisionMustBePositive::class);

        new Round(new Number\Number(42), -1);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected, $precision, $mode)
    {
        $round = new Round(new Number\Number($number), $precision, $mode);

        $this->assertSame($expected, $round->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '42.5',
            (new Round(new Number\Number(42.45), 1))->toString()
        );
    }

    public function testEquals()
    {
        $round = new Round(new Number\Number(42.45), 1);

        $this->assertTrue($round->equals(new Number\Number(42.5)));
        $this->assertTrue($round->equals(new Number\Number(
            42.499999999999999 # with a precision over 14 digits php will round it
        )));
        $this->assertFalse($round->equals(new Number\Number(42)));
    }

    public function testHigherThan()
    {
        $round = new Round(new Number\Number(42.45), 1);

        $this->assertTrue($round->higherThan(new Number\Number(42.4)));
        $this->assertFalse($round->higherThan(new Number\Number(42.5)));
    }

    public function testAdd()
    {
        $round = new Round(new Number\Number(42.5));
        $number = $round->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $round = new Round(new Number\Number(42.5));
        $number = $round->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $round = new Round(new Number\Number(42.5));
        $number = $round->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $round = new Round(new Number\Number(42.5));
        $number = $round->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $round = new Round(new Number\Number(42.45), 1);
        $number = $round->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testFloor()
    {
        $round = new Round(new Number\Number(42.45), 1);
        $number = $round->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $round = new Round(new Number\Number(42.45), 1);
        $number = $round->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $round = new Round(new Number\Number(42.45), 1);
        $number = $round->modulo(new Number\Number(21));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.5, $number->value());
    }

    public function testAbsolute()
    {
        $round = new Round(new Number\Number(-42.45), 1);
        $number = $round->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.5, $number->value());
    }

    public function testPower()
    {
        $round = new Round(new Number\Number(2.45), 1);
        $number = $round->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(6.25, $number->value());
    }

    public function testSquareRoot()
    {
        $round = new Round(new Number\Number(4.3));
        $number = $round->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Round(new Number\Number(3.6)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Round(new Number\Number(3.6)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Round(new Number\Number(3.6)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Round(new Number\Number(3.6)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Round(new Number\Number(1)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function values(): array
    {
        return [
            [42.5, 43.0, 0, Round::UP],
            [42.5, 42.0, 0, Round::DOWN],
            [42.5, 42.0, 0, Round::EVEN],
            [42.5, 43.0, 0, Round::ODD],
            [42.51, 42.5, 1, Round::UP],
            [42.51, 42.5, 1, Round::DOWN],
            [42.51, 42.5, 1, Round::EVEN],
            [42.51, 42.5, 1, Round::ODD],
            [42.51, 42.51, 2, Round::UP],
            [42.51, 42.51, 2, Round::DOWN],
            [42.51, 42.51, 2, Round::EVEN],
            [42.51, 42.51, 2, Round::ODD],
        ];
    }
}
