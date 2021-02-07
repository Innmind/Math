<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\NaturalLogarithm,
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
    Algebra\CommonLogarithm,
    Algebra\Signum,
    DefinitionSet\Set,
    Exception\OutOfDefinitionSet
};
use PHPUnit\Framework\TestCase;

class NaturalLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $ln = new NaturalLogarithm(new Number\Number(42.42));

        $this->assertInstanceOf(Number::class, $ln);
        $this->assertInstanceOf(Operation::class, $ln);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        new NaturalLogarithm(new Number\Number(0));
    }

    public function testResult()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $result = $ln->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(0.0, $result->value());
        $this->assertSame($result, $ln->result());
    }

    public function testValue()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));

        $this->assertSame(0.0, $ln->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'ln(4)',
            (new NaturalLogarithm(new Number\Number(4)))->toString()
        );
    }

    public function testEquals()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));

        $this->assertTrue($ln->equals(new Number\Number(0)));
        $this->assertFalse($ln->equals(new Number\Number(0.1)));
    }

    public function testHigherThan()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));

        $this->assertTrue($ln->higherThan(new Number\Number(-0.1)));
        $this->assertFalse($ln->higherThan(new Number\Number(0)));
    }

    public function testAdd()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->add(new Number\Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->subtract(new Number\Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $number = new NaturalLogarithm(new Number\Number(1));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $ln = new NaturalLogarithm(new Number\Number(0.5));
        $number = $ln->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.6931471805599453, $number->value());
    }

    public function testModulo()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->modulo(new Number\Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ln = new NaturalLogarithm(new Number\Number(1));
        $number = $ln->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new NaturalLogarithm(new Number\Number(1)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new NaturalLogarithm(new Number\Number(2)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\log(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new NaturalLogarithm(new Number\Number(2)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\log(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new NaturalLogarithm(new Number\Number(2)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\log(2)), $number->value());
    }

    public function testSignum()
    {
        $number = (new NaturalLogarithm(new Number\Number(2)))->signum();

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
        //ln(axb) === ln(a) + ln(b)
        $this->assertTrue(
            (new NaturalLogarithm(
                ($a = new Number\Number(2))->multiplyBy(
                    $b = new Number\Number(4)
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
                ($a = new Number\Number(2))->divideBy(
                    $b = new Number\Number(4)
                )
            ))->equals(
                (new NaturalLogarithm($a))->subtract(
                    new NaturalLogarithm($b)
                )
            )
        );
    }
}
