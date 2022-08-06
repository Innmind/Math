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
        $round = Round::up(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $round);
    }

    public function testThrowWhenNegativePrecision()
    {
        $this->expectException(PrecisionMustBePositive::class);

        Round::up(new Number\Number(42), -1);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected, $precision, $mode)
    {
        $round = Round::$mode(new Number\Number($number), $precision);

        $this->assertSame($expected, $round->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '42.5',
            (Round::up(new Number\Number(42.45), 1))->toString(),
        );
    }

    public function testEquals()
    {
        $round = Round::up(new Number\Number(42.45), 1);

        $this->assertTrue($round->equals(new Number\Number(42.5)));
        $this->assertTrue($round->equals(new Number\Number(
            42.499999999999999, # with a precision over 14 digits php will round it
        )));
        $this->assertFalse($round->equals(new Number\Number(42)));
    }

    public function testHigherThan()
    {
        $round = Round::up(new Number\Number(42.45), 1);

        $this->assertTrue($round->higherThan(new Number\Number(42.4)));
        $this->assertFalse($round->higherThan(new Number\Number(42.5)));
    }

    public function testAdd()
    {
        $round = Round::up(new Number\Number(42.5));
        $number = $round->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $round = Round::up(new Number\Number(42.5));
        $number = $round->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $round = Round::up(new Number\Number(42.5));
        $number = $round->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $round = Round::up(new Number\Number(42.5));
        $number = $round->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $number = Round::up(new Number\Number(42.45), 1);

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $round = Round::up(new Number\Number(42.45), 1);
        $number = $round->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $round = Round::up(new Number\Number(42.45), 1);
        $number = $round->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $round = Round::up(new Number\Number(42.45), 1);
        $number = $round->modulo(new Number\Number(21));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.5, $number->value());
    }

    public function testAbsolute()
    {
        $round = Round::up(new Number\Number(-42.45), 1);
        $number = $round->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.5, $number->value());
    }

    public function testPower()
    {
        $round = Round::up(new Number\Number(2.45), 1);
        $number = $round->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(6.25, $number->value());
    }

    public function testSquareRoot()
    {
        $round = Round::up(new Number\Number(4.3));
        $number = $round->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Round::up(new Number\Number(3.6))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Round::up(new Number\Number(3.6))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Round::up(new Number\Number(3.6))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Round::up(new Number\Number(3.6))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Round::up(new Number\Number(1))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function values(): array
    {
        return [
            [42.5, 43.0, 0, 'up'],
            [42.5, 42.0, 0, 'down'],
            [42.5, 42.0, 0, 'even'],
            [42.5, 43.0, 0, 'odd'],
            [42.51, 42.5, 1, 'up'],
            [42.51, 42.5, 1, 'down'],
            [42.51, 42.5, 1, 'even'],
            [42.51, 42.5, 1, 'odd'],
            [42.51, 42.51, 2, 'up'],
            [42.51, 42.51, 2, 'down'],
            [42.51, 42.51, 2, 'even'],
            [42.51, 42.51, 2, 'odd'],
        ];
    }
}
