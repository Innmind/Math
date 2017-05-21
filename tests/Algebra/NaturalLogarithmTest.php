<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\NaturalLogarithm,
    Algebra\SquareRoot,
    Algebra\Ceil,
    Algebra\Floor,
    Algebra\NumberInterface,
    Algebra\OperationInterface,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
    Algebra\Modulo,
    Algebra\Absolute,
    Algebra\Power,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    DefinitionSet\SetInterface
};
use PHPUnit\Framework\TestCase;

class NaturalLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $ln = new NaturalLogarithm(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $ln);
        $this->assertInstanceOf(OperationInterface::class, $ln);
    }

    /**
     * @expectedException Innmind\Math\Exception\OutOfDefinitionSet
     */
    public function testThrowWhenNotAllowedValue()
    {
        new NaturalLogarithm(new Number(0));
    }

    public function testResult()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $result = $ln->result();

        $this->assertInstanceOf(NumberInterface::class, $result);
        $this->assertSame(0.0, $result->value());
        $this->assertSame($result, $ln->result());
    }

    public function testValue()
    {
        $ln = new NaturalLogarithm(new Number(1));

        $this->assertSame(0.0, $ln->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'ln(4)',
            (string) new NaturalLogarithm(new Number(4))
        );
    }

    public function testEquals()
    {
        $ln = new NaturalLogarithm(new Number(1));

        $this->assertTrue($ln->equals(new Number(0)));
        $this->assertFalse($ln->equals(new Number(0.1)));
    }

    public function testHigherThan()
    {
        $ln = new NaturalLogarithm(new Number(1));

        $this->assertTrue($ln->higherThan(new Number(-0.1)));
        $this->assertFalse($ln->higherThan(new Number(0)));
    }

    public function testAdd()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $ln = new NaturalLogarithm(new Number(0.5));
        $number = $ln->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.6931471805599453, $number->value());
    }

    public function testModulo()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ln = new NaturalLogarithm(new Number(1));
        $number = $ln->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new NaturalLogarithm(new Number(1)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new NaturalLogarithm(new Number(2)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(log(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new NaturalLogarithm(new Number(2)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(log(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new NaturalLogarithm(new Number(2)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(log(2)), $number->value());
    }

    public function testSignum()
    {
        $number = (new NaturalLogarithm(new Number(2)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testDefinitionSet()
    {
        $set = BinaryLogarithm::definitionSet();

        $this->assertInstanceOf(SetInterface::class, $set);
        $this->assertSame(']0;+∞[', (string) $set);
    }

    public function testLogarithmMultiplication()
    {
        //ln(axb) === ln(a) + ln(b)
        $this->assertTrue(
            (new NaturalLogarithm(
                ($a = new Number(2))->multiplyBy(
                    $b = new Number(4)
                )
            ))->equals(
                (new NaturalLogarithm($a))->add(
                    new NaturalLogarithm($b)
                )
            )
        );
    }

    public function testLogarithmDivision()
    {
        //ln(a/b) === ln(a) - ln(b)
        $this->assertTrue(
            (new NaturalLogarithm(
                ($a = new Number(2))->divideBy(
                    $b = new Number(4)
                )
            ))->equals(
                (new NaturalLogarithm($a))->subtract(
                    new NaturalLogarithm($b)
                )
            )
        );
    }
}
