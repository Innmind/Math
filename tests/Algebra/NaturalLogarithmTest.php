<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\NaturalLogarithm,
    Algebra\SquareRoot,
    Algebra\Ceil,
    Algebra\Floor,
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
    Algebra\Real,
    DefinitionSet\Set,
    Exception\OutOfDefinitionSet
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NaturalLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $ln = NaturalLogarithm::of(Real::of(42.42));

        $this->assertInstanceOf(Number::class, $ln);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        NaturalLogarithm::of(Real::of(0));
    }

    public function testResult()
    {
        $ln = NaturalLogarithm::of(Real::of(1));

        $this->assertSame(0.0, $ln->value());
    }

    public function testValue()
    {
        $ln = NaturalLogarithm::of(Real::of(1));

        $this->assertSame(0.0, $ln->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'ln(4)',
            NaturalLogarithm::of(Real::of(4))->toString(),
        );
    }

    public function testEquals()
    {
        $ln = NaturalLogarithm::of(Real::of(1));

        $this->assertTrue($ln->equals(Real::of(0)));
        $this->assertFalse($ln->equals(Real::of(0.1)));
    }

    public function testHigherThan()
    {
        $ln = NaturalLogarithm::of(Real::of(1));

        $this->assertTrue($ln->higherThan(Real::of(-0.1)));
        $this->assertFalse($ln->higherThan(Real::of(0)));
    }

    public function testAdd()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->add(Real::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->subtract(Real::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $number = NaturalLogarithm::of(Real::of(1));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $ln = NaturalLogarithm::of(Real::of(0.5));
        $number = $ln->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.6931471805599453, $number->value());
    }

    public function testModulo()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->modulo(Real::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ln = NaturalLogarithm::of(Real::of(1));
        $number = $ln->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = NaturalLogarithm::of(Real::of(1))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = NaturalLogarithm::of(Real::of(2))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\log(2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = NaturalLogarithm::of(Real::of(2))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\log(2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = NaturalLogarithm::of(Real::of(2))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\log(2)), $number->value());
    }

    public function testSignum()
    {
        $number = NaturalLogarithm::of(Real::of(2))->signum();

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
            NaturalLogarithm::of(
                ($a = Real::of(2))->multiplyBy(
                    $b = Real::of(4),
                ),
            )->equals(
                NaturalLogarithm::of($a)->add(
                    NaturalLogarithm::of($b),
                ),
            ),
        );
    }

    public function testLogarithmDivision()
    {
        //ln(a/b) === ln(a) - ln(b)
        $this->assertTrue(
            NaturalLogarithm::of(
                ($a = Real::of(2))->divideBy(
                    $b = Real::of(4),
                ),
            )->equals(
                NaturalLogarithm::of($a)->subtract(
                    NaturalLogarithm::of($b),
                ),
            ),
        );
    }
}
