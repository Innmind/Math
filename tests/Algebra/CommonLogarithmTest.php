<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\CommonLogarithm,
    Algebra\SquareRoot,
    Algebra\Ceil,
    Algebra\Floor,
    Algebra\Operation,
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
    Algebra\NaturalLogarithm,
    Algebra\Signum,
    DefinitionSet\Set,
    Exception\OutOfDefinitionSet
};
use PHPUnit\Framework\TestCase;

class CommonLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lg = new CommonLogarithm(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $lg);
        $this->assertInstanceOf(Operation::class, $lg);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        new CommonLogarithm(new Number\Number(0));
    }

    public function testResult()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $result = $lg->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(0.0, $result->value());
        $this->assertSame($result, $lg->result());
    }

    public function testValue()
    {
        $lg = new CommonLogarithm(new Number\Number(1));

        $this->assertSame(0.0, $lg->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lg(4)',
            (new CommonLogarithm(new Number\Number(4)))->toString()
        );
    }

    public function testEquals()
    {
        $lg = new CommonLogarithm(new Number\Number(1));

        $this->assertTrue($lg->equals(new Number\Number(0)));
        $this->assertFalse($lg->equals(new Number\Number(0.1)));
    }

    public function testHigherThan()
    {
        $lg = new CommonLogarithm(new Number\Number(1));

        $this->assertTrue($lg->higherThan(new Number\Number(-0.1)));
        $this->assertFalse($lg->higherThan(new Number\Number(0)));
    }

    public function testAdd()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testFloor()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lg = new CommonLogarithm(new Number\Number(0.5));
        $number = $lg->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.3010299956639812, $number->value());
    }

    public function testModulo()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->modulo(new Number\Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lg = new CommonLogarithm(new Number\Number(1));
        $number = $lg->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new CommonLogarithm(new Number\Number(1)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new CommonLogarithm(new Number\Number(2)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(log10(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new CommonLogarithm(new Number\Number(2)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(log10(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new CommonLogarithm(new Number\Number(2)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(log10(2)), $number->value());
    }

    public function testSignum()
    {
        $number = (new CommonLogarithm(new Number\Number(2)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testDefinitionSet()
    {
        $set = BinaryLogarithm::definitionSet();

        $this->assertInstanceOf(Set::class, $set);
        $this->assertSame(']0;+∞[', $set->toString());
    }

    public function testLogarithmMultiplication()
    {
        //lg(axb) === lg(a) + lg(b)
        $this->assertTrue(
            (new CommonLogarithm(
                ($a = new Number\Number(2))->multiplyBy(
                    $b = new Number\Number(4)
                )
            ))->equals(
                (new CommonLogarithm($a))->add(
                    new CommonLogarithm($b)
                )
            )
        );
    }

    public function testLogarithmDivision()
    {
        //lg(a/b) === lg(a) - lg(b)
        $this->assertTrue(
            (new CommonLogarithm(
                ($a = new Number\Number(2))->divideBy(
                    $b = new Number\Number(4)
                )
            ))->equals(
                (new CommonLogarithm($a))->subtract(
                    new CommonLogarithm($b)
                )
            )
        );
    }
}
