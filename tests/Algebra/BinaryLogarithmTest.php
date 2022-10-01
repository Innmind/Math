<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\{
    Algebra\BinaryLogarithm,
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
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum,
    Algebra\Real,
    DefinitionSet\Set,
    Exception\OutOfDefinitionSet
};
use PHPUnit\Framework\TestCase;

class BinaryLogarithmTest extends TestCase
{
    public function testInterface()
    {
        $lb = BinaryLogarithm::of(Real::of(42.42));

        $this->assertInstanceOf(Number::class, $lb);
        $this->assertInstanceOf(Operation::class, $lb);
    }

    public function testThrowWhenNotAllowedValue()
    {
        $this->expectException(OutOfDefinitionSet::class);

        BinaryLogarithm::of(Real::of(0));
    }

    public function testResult()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $result = $lb->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(0.0, $result->value());
    }

    public function testValue()
    {
        $lb = BinaryLogarithm::of(Real::of(1));

        $this->assertSame(0.0, $lb->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            'lb(4)',
            BinaryLogarithm::of(Real::of(4))->toString(),
        );
    }

    public function testEquals()
    {
        $lb = BinaryLogarithm::of(Real::of(1));

        $this->assertTrue($lb->equals(Real::of(0)));
        $this->assertFalse($lb->equals(Real::of(0.1)));
    }

    public function testHigherThan()
    {
        $lb = BinaryLogarithm::of(Real::of(1));

        $this->assertTrue($lb->higherThan(Real::of(-0.1)));
        $this->assertFalse($lb->higherThan(Real::of(0)));
    }

    public function testAdd()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->add(Real::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testSubtract()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->subtract(Real::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-7.0, $number->value());
    }

    public function testMultiplication()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testDivision()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testRound()
    {
        $number = BinaryLogarithm::of(Real::of(1));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $lb = BinaryLogarithm::of(Real::of(0.5));
        $number = $lb->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->modulo(Real::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testSquareRoot()
    {
        $lb = BinaryLogarithm::of(Real::of(1));
        $number = $lb->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testExponential()
    {
        $number = BinaryLogarithm::of(Real::of(1))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = BinaryLogarithm::of(Real::of(2))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(\log(2, 2), 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = BinaryLogarithm::of(Real::of(2))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(\log(2, 2)), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = BinaryLogarithm::of(Real::of(2))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(\log(2, 2)), $number->value());
    }

    public function testSignum()
    {
        $number = BinaryLogarithm::of(Real::of(2))->signum();

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
        //lb(axb) === lb(a) + lb(b)
        $this->assertTrue(
            BinaryLogarithm::of(
                ($a = Real::of(2))->multiplyBy(
                    $b = Real::of(4),
                ),
            )->equals(
                BinaryLogarithm::of($a)->add(
                    BinaryLogarithm::of($b),
                ),
            ),
        );
    }

    public function testLogarithmDivision()
    {
        //lb(a/b) === lb(a) - lb(b)
        $this->assertTrue(
            BinaryLogarithm::of(
                ($a = Real::of(2))->divideBy(
                    $b = Real::of(4),
                ),
            )->equals(
                BinaryLogarithm::of($a)->subtract(
                    BinaryLogarithm::of($b),
                ),
            ),
        );
    }
}
