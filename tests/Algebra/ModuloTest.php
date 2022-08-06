<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Modulo,
    Operation,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
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

class ModuloTest extends TestCase
{
    public function testInterface()
    {
        $modulo = new Modulo(
            $this->createMock(Number::class),
            $this->createMock(Number::class),
        );

        $this->assertInstanceOf(Number::class, $modulo);
        $this->assertInstanceOf(Operation::class, $modulo);
    }

    public function testResult()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $result = $modulo->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertEqualsWithDelta(0.24, $result->value(), 0.0001);
        $this->assertSame($result, $modulo->result());
    }

    public function testStringCast()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );

        $this->assertSame('42.24 % 2.1', $modulo->toString());
    }

    public function testStringCastOperations()
    {
        $modulo = new Modulo(
            new Addition(
                new Number\Number(1),
                new Number\Number(1),
            ),
            new Addition(
                new Number\Number(2),
                new Number\Number(2),
            ),
        );

        $this->assertSame('(1 + 1) % (2 + 2)', $modulo->toString());
    }

    public function testEquals()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );

        $this->assertTrue($modulo->equals(new Number\Number(0.2400000000000002)));
        $this->assertFalse($modulo->equals(new Number\Number(1.24)));
    }

    public function testHigherThan()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );

        $this->assertTrue($modulo->higherThan(new Number\Number(0.23)));
        $this->assertFalse($modulo->higherThan(new Number\Number(0.2400000000000002)));
    }

    public function testAdd()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(66.24, $number->value());
    }

    public function testSubtract()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.76, $number->value());
    }

    public function testDivideBy()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.12, $number->value());
    }

    public function testMulitplyBy()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertEqualsWithDelta(0.48, $number->value(), 0.0001);
    }

    public function testRound()
    {
        $number = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $modulo = new Modulo(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->modulo(new Number\Number(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.04, $number->value());
    }

    public function testAbsolute()
    {
        $modulo = new Modulo(
            new Number\Number(-42.24),
            new Number\Number(2.1),
        );
        $number = $modulo->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertEqualsWithDelta(0.24, $number->value(), 0.00001);
    }

    public function testPower()
    {
        $modulo = new Modulo(
            new Number\Number(9),
            new Number\Number(2),
        );
        $number = $modulo->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testSquareRoot()
    {
        $modulo = new Modulo(
            new Number\Number(12),
            new Number\Number(8),
        );
        $number = $modulo->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Modulo(
            new Number\Number(12),
            new Number\Number(8),
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Modulo(
            new Number\Number(12),
            new Number\Number(8),
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Modulo(
            new Number\Number(12),
            new Number\Number(8),
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Modulo(
            new Number\Number(12),
            new Number\Number(8),
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Modulo(
            new Number\Number(12),
            new Number\Number(8),
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
