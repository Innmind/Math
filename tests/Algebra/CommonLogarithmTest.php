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
        $lg = CommonLogarithm::of(Number\Number::of(42.42));

        $this->assertInstanceOf(Number::class, $lg);
        $this->assertInstanceOf(Operation::class, $lg);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        CommonLogarithm::of(Number\Number::of(0));
    }

    public function testResult()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $result = $lg->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(0.0, $result->value());
    }

    public function testValue()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));

        $this->assertSame(0.0, $lg->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lg(4)',
            CommonLogarithm::of(Number\Number::of(4))->toString(),
        );
    }

    public function testEquals()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));

        $this->assertTrue($lg->equals(Number\Number::of(0)));
        $this->assertFalse($lg->equals(Number\Number::of(0.1)));
    }

    public function testHigherThan()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));

        $this->assertTrue($lg->higherThan(Number\Number::of(-0.1)));
        $this->assertFalse($lg->higherThan(Number\Number::of(0)));
    }

    public function testAdd()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->add(Number\Number::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->subtract(Number\Number::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $number = CommonLogarithm::of(Number\Number::of(1));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lg = CommonLogarithm::of(Number\Number::of(0.5));
        $number = $lg->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.3010299956639812, $number->value());
    }

    public function testModulo()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->modulo(Number\Number::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lg = CommonLogarithm::of(Number\Number::of(1));
        $number = $lg->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = CommonLogarithm::of(Number\Number::of(1))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = CommonLogarithm::of(Number\Number::of(2))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\log10(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = CommonLogarithm::of(Number\Number::of(2))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\log10(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = CommonLogarithm::of(Number\Number::of(2))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\log10(2)), $number->value());
    }

    public function testSignum()
    {
        $number = CommonLogarithm::of(Number\Number::of(2))->signum();

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
            CommonLogarithm::of(
                ($a = Number\Number::of(2))->multiplyBy(
                    $b = Number\Number::of(4),
                ),
            )->equals(
                CommonLogarithm::of($a)->add(
                    CommonLogarithm::of($b),
                ),
            ),
        );
    }

    public function testLogarithmDivision()
    {
        //lg(a/b) === lg(a) - lg(b)
        $this->assertTrue(
            CommonLogarithm::of(
                ($a = Number\Number::of(2))->divideBy(
                    $b = Number\Number::of(4),
                ),
            )->equals(
                CommonLogarithm::of($a)->subtract(
                    CommonLogarithm::of($b),
                ),
            ),
        );
    }
}
