<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    SquareRoot,
    Ceil,
    Floor,
    Operation,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Modulo,
    Absolute,
    Power,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
    Integer,
};
use PHPUnit\Framework\TestCase;

class SquareRootTest extends TestCase
{
    public function testInterface()
    {
        $sqrt = SquareRoot::of(Number\Number::of(42.42));

        $this->assertInstanceOf(Number::class, $sqrt);
        $this->assertInstanceOf(Operation::class, $sqrt);
    }

    public function testResult()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $result = $sqrt->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2.0, $result->value());
    }

    public function testValue()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));

        $this->assertSame(2.0, $sqrt->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '√4',
            SquareRoot::of(Number\Number::of(4))->toString(),
        );
    }

    public function testEquals()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));

        $this->assertTrue($sqrt->equals(Number\Number::of(2)));
        $this->assertFalse($sqrt->equals(Number\Number::of(4.1)));
    }

    public function testHigherThan()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));

        $this->assertTrue($sqrt->higherThan(Number\Number::of(0)));
        $this->assertFalse($sqrt->higherThan(Number\Number::of(4)));
    }

    public function testAdd()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->add(Number\Number::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testSubtract()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->subtract(Number\Number::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-5.0, $number->value());
    }

    public function testMultiplication()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testDivision()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testRound()
    {
        $number = SquareRoot::of(Number\Number::of(2));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $sqrt = SquareRoot::of(Number\Number::of(2));
        $number = $sqrt->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testCeil()
    {
        $sqrt = SquareRoot::of(Number\Number::of(2));
        $number = $sqrt->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testModulo()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->modulo(Number\Number::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $sqrt = SquareRoot::of(Number\Number::of(4));
        $number = $sqrt->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testSquareRoot()
    {
        $sqrt = SquareRoot::of(Number\Number::of(16));
        $number = $sqrt->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = SquareRoot::of(Number\Number::of(16))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = SquareRoot::of(Number\Number::of(16))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = SquareRoot::of(Number\Number::of(16))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = SquareRoot::of(Number\Number::of(16))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = SquareRoot::of(Number\Number::of(16))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testSquareOfSquareRoot()
    {
        //sqrt(a)^2 === a
        $this->assertTrue(
            ($a = Number\Number::of(9))
                ->squareRoot()
                ->power(Number\Number::of(2))
                ->equals($a),
        );
    }

    public function testSquareRootOfMultiplication()
    {
        //sqrt(a*b) === sqrt(a) * sqrt(b)
        $this->assertTrue(
            ($a = Number\Number::of(4))
                ->multiplyBy($b = Number\Number::of(9))
                ->squareRoot()
                ->equals(
                    $a
                        ->squareRoot()
                        ->multiplyBy(
                            $b->squareRoot(),
                        ),
                ),
        );
    }

    public function testSquareRootOfDivision()
    {
        //sqrt(a/b) === sqrt(a) / sqrt(b)
        $this->assertTrue(
            ($a = Number\Number::of(4))
                ->divideBy($b = Number\Number::of(9))
                ->squareRoot()
                ->equals(
                    $a
                        ->squareRoot()
                        ->divideBy(
                            $b->squareRoot(),
                        ),
                ),
        );
    }

    public function testSquareRootAddition()
    {
        //sqrt(a*n) + sqrt(b*n) === sqrt((sqrt(a) + sqrt(b))^2 * n)
        $this->assertTrue(
            ($a = Number\Number::of(9))
                ->multiplyBy($n = Number\Number::of(2))
                ->squareRoot()
                ->add(
                    ($b = Number\Number::of(4))
                        ->multiplyBy($n)
                        ->squareRoot(),
                )
                ->equals(
                    $a
                        ->squareRoot()
                        ->add(
                            $b->squareRoot(),
                        )
                        ->power(Number\Number::of(2))
                        ->multiplyBy($n)
                        ->squareRoot(),
                ),
        );
    }

    public function testSquareRootAsPowerNotation()
    {
        //sqrt(a) === a^0.5
        $this->assertTrue(
            ($a = Number\Number::of(4))
                ->squareRoot()
                ->equals(
                    $a->power(Number\Number::of(0.5)),
                ),
        );
    }

    public function testCollapseSquare()
    {
        $result = Integer::of(2)
            ->power(Integer::of(2))
            ->squareRoot()
            ->collapse()
            ->value();

        $this->assertSame(2, $result);

        $result = Integer::of(2)
            ->power(Integer::of(2))
            ->squareRoot()
            ->power(Integer::of(2))
            ->squareRoot()
            ->collapse()
            ->value();

        $this->assertSame(2, $result);
    }
}
