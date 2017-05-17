<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\BinaryLogarithm,
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
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    DefinitionSet\SetInterface
};
use PHPUnit\Framework\TestCase;

class BinaryLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lb = new BinaryLogarithm(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $lb);
        $this->assertInstanceOf(OperationInterface::class, $lb);
    }

    /**
     * @expectedException Innmind\Math\Exception\OutOfDefinitionSetException
     */
    public function testThrowWhenNotAllowedValue()
    {
        new BinaryLogarithm(new Number(0));
    }

    public function testResult()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $result = $lb->result();

        $this->assertInstanceOf(NumberInterface::class, $result);
        $this->assertSame(0.0, $result->value());
        $this->assertSame($result, $lb->result());
    }

    public function testValue()
    {
        $lb = new BinaryLogarithm(new Number(1));

        $this->assertSame(0.0, $lb->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lb(4)',
            (string) new BinaryLogarithm(new Number(4))
        );
    }

    public function testEquals()
    {
        $lb = new BinaryLogarithm(new Number(1));

        $this->assertTrue($lb->equals(new Number(0)));
        $this->assertFalse($lb->equals(new Number(0.1)));
    }

    public function testHigherThan()
    {
        $lb = new BinaryLogarithm(new Number(1));

        $this->assertTrue($lb->higherThan(new Number(-0.1)));
        $this->assertFalse($lb->higherThan(new Number(0)));
    }

    public function testAdd()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lb = new BinaryLogarithm(new Number(0.5));
        $number = $lb->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lb = new BinaryLogarithm(new Number(1));
        $number = $lb->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new BinaryLogarithm(new Number(1)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new BinaryLogarithm(new Number(2)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(log(2, 2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new BinaryLogarithm(new Number(2)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(log(2, 2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new BinaryLogarithm(new Number(2)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(log(2, 2)), $number->value());
    }

    public function testSignum()
    {
        $number = (new BinaryLogarithm(new Number(2)))->signum();

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
        //lb(axb) === lb(a) + lb(b)
        $this->assertTrue(
            (new BinaryLogarithm(
                ($a = new Number(2))->multiplyBy(
                    $b = new Number(4)
                )
            ))->equals(
                (new BinaryLogarithm($a))->add(
                    new BinaryLogarithm($b)
                )
            )
        );
    }

    public function testLogarithmDivision()
    {
        //lb(a/b) === lb(a) - lb(b)
        $this->assertTrue(
            (new BinaryLogarithm(
                ($a = new Number(2))->divideBy(
                    $b = new Number(4)
                )
            ))->equals(
                (new BinaryLogarithm($a))->subtract(
                    new BinaryLogarithm($b)
                )
            )
        );
    }
}
