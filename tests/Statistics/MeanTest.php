<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Mean,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
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
    Algebra\Signum
};
use PHPUnit\Framework\TestCase;

class MeanTest extends TestCase
{
    public function testResult()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(2),
            new Number\Number(2),
            new Number\Number(2),
            new Number\Number(3),
            new Number\Number(5),
            new Number\Number(5),
            new Number\Number(6),
            new Number\Number(6),
            new Number\Number(7)
        );

        $this->assertInstanceOf(Number::class, $mean->result());
        $this->assertSame($mean->result(), $mean->result());
        $this->assertSame(3.9, $mean->result()->value());
    }

    public function testEquals()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );

        $this->assertTrue($mean->equals(new Number\Number(4)));
        $this->assertTrue($mean->equals(new Number\Number(4.0)));
        $this->assertFalse($mean->equals(new Number\Number(4.1)));
    }

    public function testHigherThan()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );

        $this->assertTrue($mean->higherThan(new Number\Number(3.9)));
        $this->assertFalse($mean->higherThan(new Number\Number(4)));
    }

    public function testAdd()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = new Mean(
            new Number\Number(1),
            new Number\Number(7.12)
        );

        $this->assertSame(4.1, $number->roundUp(1)->value());
        $this->assertSame(4.1, $number->roundDown(1)->value());
        $this->assertSame(4.1, $number->roundEven(1)->value());
        $this->assertSame(4.1, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7.1)
        );
        $number = $mean->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7.1)
        );
        $number = $mean->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->modulo(new Number\Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $mean = new Mean(
            new Number\Number(-1),
            new Number\Number(-7)
        );
        $number = $mean->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(4, $number->value());
    }

    public function testPower()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7)
        );
        $number = $mean->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Mean(
            new Number\Number(1),
            new Number\Number(7)
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Mean(
            new Number\Number(1),
            new Number\Number(7)
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Mean(
            new Number\Number(1),
            new Number\Number(7)
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Mean(
            new Number\Number(1),
            new Number\Number(7)
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $mean = new Mean(
            new Number\Number(1),
            new Number\Number(7.1)
        );

        $this->assertSame('(1 + 7.1) ÷ 2', $mean->toString());
    }
}
