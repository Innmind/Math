<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Power,
    Operation,
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
};
use PHPUnit\Framework\TestCase;

class PowerTest extends TestCase
{
    public function testInterface()
    {
        $power = Power::of(
            $this->createMock(Number::class),
            $this->createMock(Number::class),
        );

        $this->assertInstanceOf(Number::class, $power);
        $this->assertInstanceOf(Operation::class, $power);
    }

    public function testResult()
    {
        $power = Power::of(
            Number\Number::of(42.24),
            Number\Number::of(2.1),
        );
        $result = $power->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2594.300085723648, $result->value());
    }

    public function testStringCast()
    {
        $power = Power::of(
            Number\Number::of(42.24),
            Number\Number::of(2.1),
        );

        $this->assertSame('42.24^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = Power::of(
            Addition::of(
                Number\Number::of(1),
                Number\Number::of(1),
            ),
            Addition::of(
                Number\Number::of(2),
                Number\Number::of(2),
            ),
        );

        $this->assertSame('(1 + 1)^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2.1),
        );

        $this->assertTrue($power->equals(Number\Number::of(4.2870938501451725)));
        $this->assertFalse($power->equals(Number\Number::of(4)));
    }

    public function testHigherThan()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2.1),
        );

        $this->assertTrue($power->higherThan(Number\Number::of(4.28709385)));
        $this->assertFalse($power->higherThan(Number\Number::of(4.2870938501451725)));
    }

    public function testAdd()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->modulo(Number\Number::of(0.5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $power = Power::of(
            Number\Number::of(-2),
            Number\Number::of(3),
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testPower()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $power = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Power::of(
            Number\Number::of(2),
            Number\Number::of(2),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testNegativePower()
    {
        //a^-n === 1/(a^n)
        $this->assertTrue(
            ($a = Number\Number::of(2))
                ->power($n = Number\Number::of(-3))
                ->equals(
                    (Number\Number::of(1))->divideBy(
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
            ($x = Number\Number::of(2))
                ->power(
                    ($a = Number\Number::of(3))->add($b = Number\Number::of(4)),
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
            ($x = Number\Number::of(2))
                ->power(
                    ($a = Number\Number::of(3))->subtract($b = Number\Number::of(4)),
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
            ($x = Number\Number::of(2))
                ->power($a = Number\Number::of(3))
                ->power($b = Number\Number::of(4))
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
            ($a = Number\Number::of(2))
                ->multiplyBy($b = Number\Number::of(3))
                ->power($n = Number\Number::of(4))
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
