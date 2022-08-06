<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Signum,
    Power,
    Operation,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm
};
use PHPUnit\Framework\TestCase;

class SignumTest extends TestCase
{
    public function testInterface()
    {
        $sgn = new Signum(
            $this->createMock(Number::class),
        );

        $this->assertInstanceOf(Number::class, $sgn);
        $this->assertInstanceOf(Operation::class, $sgn);
    }

    public function testResult()
    {
        $sgn = new Signum(
            new Number\Number(42),
        );
        $result = $sgn->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(1, $result->value());

        $this->assertSame(-1, (new Signum(new Number\Number(-42)))->value());
        $this->assertSame(0, (new Signum(new Number\Number(0)))->value());
    }

    public function testStringCast()
    {
        $sgn = new Signum(
            new Number\Number(42.24),
        );

        $this->assertSame('sgn(42.24)', $sgn->toString());
    }

    public function testStringCastOperations()
    {
        $sgn = new Signum(
            new Addition(
                new Number\Number(1),
                new Number\Number(1),
            ),
        );

        $this->assertSame('sgn(1 + 1)', $sgn->toString());
    }

    public function testEquals()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );

        $this->assertTrue($sgn->equals(new Number\Number(1)));
        $this->assertFalse($sgn->equals(new Number\Number(0)));
    }

    public function testHigherThan()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );

        $this->assertTrue($sgn->higherThan(new Number\Number(0)));
        $this->assertFalse($sgn->higherThan(new Number\Number(1)));
    }

    public function testAdd()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(67, $number->value());
    }

    public function testSubtract()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65, $number->value());
    }

    public function testDivideBy()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.5, $number->value());
    }

    public function testMulitplyBy()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testRound()
    {
        $number = new Signum(
            new Number\Number(2),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testCeil()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->modulo(new Number\Number(0.5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $sgn = new Signum(
            new Number\Number(-2),
        );
        $number = $sgn->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testPower()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testSquareRoot()
    {
        $sgn = new Signum(
            new Number\Number(2),
        );
        $number = $sgn->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Signum(
            new Number\Number(2),
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(1), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Signum(
            new Number\Number(2),
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(1, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Signum(
            new Number\Number(2),
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(1), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Signum(
            new Number\Number(2),
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(1), $number->value());
    }

    public function testSignum()
    {
        $number = (new Signum(new Number\Number(1)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
