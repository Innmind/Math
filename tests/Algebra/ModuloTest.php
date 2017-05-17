<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Modulo,
    NumberInterface,
    OperationInterface,
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
            $this->createMock(NumberInterface::class),
            $this->createMock(NumberInterface::class)
        );

        $this->assertInstanceOf(NumberInterface::class, $modulo);
        $this->assertInstanceOf(OperationInterface::class, $modulo);
    }

    public function testResult()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $result = $modulo->result();

        $this->assertInstanceOf(NumberInterface::class, $result);
        $this->assertSame(0.24, $result->value());
        $this->assertSame($result, $modulo->result());
    }

    public function testStringCast()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );

        $this->assertSame('42.24 % 2.1', (string) $modulo);
    }

    public function testStringCastOperations()
    {
        $modulo = new Modulo(
            new Addition(
                new Number(1),
                new Number(1)
            ),
            new Addition(
                new Number(2),
                new Number(2)
            )
        );

        $this->assertSame('(1 + 1) % (2 + 2)', (string) $modulo);
    }

    public function testEquals()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );

        $this->assertTrue($modulo->equals(new Number(0.2400000000000002)));
        $this->assertFalse($modulo->equals(new Number(1.24)));
    }

    public function testHigherThan()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );

        $this->assertTrue($modulo->higherThan(new Number(0.23)));
        $this->assertFalse($modulo->higherThan(new Number(0.2400000000000002)));
    }

    public function testAdd()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(66.24, $number->value());
    }

    public function testSubtract()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.76, $number->value());
    }

    public function testDivideBy()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.12, $number->value());
    }

    public function testMulitplyBy()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.48, $number->value());
    }

    public function testRound()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(0.2, $number->value());
    }

    public function testFloor()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $modulo = new Modulo(
            new Number(42.24),
            new Number(2.1)
        );
        $number = $modulo->modulo(new Number(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.04, $number->value());
    }

    public function testAbsolute()
    {
        $modulo = new Modulo(
            new Number(-42.24),
            new Number(2.1)
        );
        $number = $modulo->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.24, $number->value());
    }

    public function testPower()
    {
        $modulo = new Modulo(
            new Number(9),
            new Number(2)
        );
        $number = $modulo->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testSquareRoot()
    {
        $modulo = new Modulo(
            new Number(12),
            new Number(8)
        );
        $number = $modulo->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Modulo(
            new Number(12),
            new Number(8)
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Modulo(
            new Number(12),
            new Number(8)
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Modulo(
            new Number(12),
            new Number(8)
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Modulo(
            new Number(12),
            new Number(8)
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Modulo(
            new Number(12),
            new Number(8)
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
