<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Power,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
    Integer,
    Real,
    Value,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PowerTest extends TestCase
{
    public function testInterface()
    {
        $power = Power::of(
            Value::one,
            Value::one,
        );

        $this->assertInstanceOf(Number::class, $power);
    }

    public function testResult()
    {
        $power = Power::of(
            Real::of(42.24),
            Real::of(2.1),
        );
        $result = $power->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2594.300085723648, $result->value());
    }

    public function testStringCast()
    {
        $power = Power::of(
            Real::of(42.24),
            Real::of(2.1),
        );

        $this->assertSame('42.24^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = Power::of(
            Addition::of(
                Real::of(1),
                Real::of(1),
            ),
            Addition::of(
                Real::of(2),
                Real::of(2),
            ),
        );

        $this->assertSame('(1 + 1)^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2.1),
        );

        $this->assertTrue($power->equals(Real::of(4.2870938501451725)));
        $this->assertFalse($power->equals(Real::of(4)));
    }

    public function testHigherThan()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2.1),
        );

        $this->assertTrue($power->higherThan(Real::of(4.28709385)));
        $this->assertFalse($power->higherThan(Real::of(4.2870938501451725)));
    }

    public function testAdd()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = Power::of(
            Real::of(2),
            Real::of(2),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->modulo(Real::of(0.5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $power = Power::of(
            Real::of(-2),
            Real::of(3),
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testPower()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $power = Power::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Power::of(
            Real::of(2),
            Real::of(2),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Power::of(
            Real::of(2),
            Real::of(2),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Power::of(
            Real::of(2),
            Real::of(2),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Power::of(
            Real::of(2),
            Real::of(2),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Power::of(
            Real::of(2),
            Real::of(2),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testNegativePower()
    {
        //a^-n === 1/(a^n)
        $this->assertTrue(
            ($a = Real::of(2))
                ->power($n = Real::of(-3))
                ->equals(
                    (Real::of(1))->divideBy(
                        $a->power(
                            $n->absolute(),
                        ),
                    ),
                ),
        );
    }

    public function testPowerAddition()
    {
        //x^(a+b) === x^a + x^b
        $this->assertTrue(
            ($x = Real::of(2))
                ->power(
                    ($a = Real::of(3))->add($b = Real::of(4)),
                )
                ->equals(
                    $x
                        ->power($a)
                        ->multiplyBy(
                            $x->power($b),
                        ),
                ),
        );
    }

    public function testPowerSubtraction()
    {
        //x^(a-b) === x^a / x^b
        $this->assertTrue(
            ($x = Real::of(2))
                ->power(
                    ($a = Real::of(3))->subtract($b = Real::of(4)),
                )
                ->equals(
                    $x
                        ->power($a)
                        ->divideBy(
                            $x->power($b),
                        ),
                ),
        );
    }

    public function testPowerMultiplication()
    {
        //(x^a)^b === x^(a*b)
        $this->assertTrue(
            ($x = Real::of(2))
                ->power($a = Real::of(3))
                ->power($b = Real::of(4))
                ->equals(
                    $x->power(
                        $a->multiplyBy($b),
                    ),
                ),
        );
    }

    public function testPowerDistribution()
    {
        //(a*b)^n = a^n * b^n
        $this->assertTrue(
            ($a = Real::of(2))
                ->multiplyBy($b = Real::of(3))
                ->power($n = Real::of(4))
                ->equals(
                    $a
                        ->power($n)
                        ->multiplyBy(
                            $b->power($n),
                        ),
                ),
        );
    }

    public function testCollapseSquareRoot()
    {
        $result = Integer::of(2)
            ->squareRoot()
            ->power(Integer::of(2))
            ->collapse()
            ->value();

        $this->assertSame(2, $result);

        $result = Integer::of(2)
            ->squareRoot()
            ->power(Integer::of(2))
            ->squareRoot()
            ->power(Integer::of(2))
            ->collapse()
            ->value();

        $this->assertSame(2, $result);
    }
}
