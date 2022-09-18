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
        $sgn = Signum::of(
            $this->createMock(Number::class),
        );

        $this->assertInstanceOf(Number::class, $sgn);
        $this->assertInstanceOf(Operation::class, $sgn);
    }

    public function testResult()
    {
        $sgn = Signum::of(
            Number\Number::of(42),
        );
        $result = $sgn->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(1, $result->value());

        $this->assertSame(-1, (Signum::of(Number\Number::of(-42)))->value());
        $this->assertSame(0, (Signum::of(Number\Number::of(0)))->value());
    }

    public function testStringCast()
    {
        $sgn = Signum::of(
            Number\Number::of(42.24),
        );

        $this->assertSame('sgn(42.24)', $sgn->toString());
    }

    public function testStringCastOperations()
    {
        $sgn = Signum::of(
            Addition::of(
                Number\Number::of(1),
                Number\Number::of(1),
            ),
        );

        $this->assertSame('sgn(1 + 1)', $sgn->toString());
    }

    public function testEquals()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );

        $this->assertTrue($sgn->equals(Number\Number::of(1)));
        $this->assertFalse($sgn->equals(Number\Number::of(0)));
    }

    public function testHigherThan()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );

        $this->assertTrue($sgn->higherThan(Number\Number::of(0)));
        $this->assertFalse($sgn->higherThan(Number\Number::of(1)));
    }

    public function testAdd()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(67, $number->value());
    }

    public function testSubtract()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65, $number->value());
    }

    public function testDivideBy()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.5, $number->value());
    }

    public function testMulitplyBy()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testRound()
    {
        $number = Signum::of(
            Number\Number::of(2),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testCeil()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->modulo(Number\Number::of(0.5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $sgn = Signum::of(
            Number\Number::of(-2),
        );
        $number = $sgn->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testPower()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testSquareRoot()
    {
        $sgn = Signum::of(
            Number\Number::of(2),
        );
        $number = $sgn->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testExponential()
    {
        $number = Signum::of(
            Number\Number::of(2),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(1), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Signum::of(
            Number\Number::of(2),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(1, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Signum::of(
            Number\Number::of(2),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(1), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Signum::of(
            Number\Number::of(2),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(1), $number->value());
    }

    public function testSignum()
    {
        $number = Signum::of(Number\Number::of(1))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
