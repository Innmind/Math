<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Multiplication,
    Number,
    Operation,
    Addition,
    Subtraction,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
    Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
{
    public function testInterface()
    {
        $multiplication = Multiplication::of(
            Real::of(4),
            Real::of(42),
        );

        $this->assertInstanceOf(Operation::class, $multiplication);
        $this->assertInstanceOf(Number::class, $multiplication);
        $this->assertSame('4 x 42', $multiplication->toString());
    }

    public function testResult()
    {
        $multiplication = Multiplication::of(
            Real::of(42),
            Real::of(24),
        );
        $result = $multiplication->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(1008, $result->value());
        $this->assertTrue($result->equals($multiplication->product()));
    }

    public function testValue()
    {
        $multiplication = Multiplication::of(
            Real::of(4),
            Real::of(2),
        );

        $this->assertSame(8, $multiplication->value());
    }

    public function testEquals()
    {
        $multiplication = Multiplication::of(
            Real::of(4),
            Real::of(2),
        );

        $this->assertTrue($multiplication->equals(Real::of(8)));
        $this->assertFalse($multiplication->equals(Real::of(8.1)));
    }

    public function testHigherThan()
    {
        $multiplication = Multiplication::of(
            Real::of(4),
            Real::of(2),
        );

        $this->assertFalse($multiplication->higherThan(Real::of(8)));
        $this->assertTrue($multiplication->higherThan(Real::of(7.9)));
    }

    public function testAdd()
    {
        $multiplication = Multiplication::of(
            Real::of(4),
            Real::of(2),
        );
        $number = $multiplication->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(74, $number->value());
    }

    public function testSubtract()
    {
        $multiplication = Multiplication::of(
            Real::of(4),
            Real::of(2),
        );
        $number = $multiplication->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-58, $number->value());
    }

    public function testDivideBy()
    {
        $multiplication = Multiplication::of(
            Real::of(4.5),
            Real::of(2),
        );
        $number = $multiplication->divideBy(Real::of(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $multiplication = Addition::of(
            Real::of(24),
            Real::of(42),
        );
        $number = $multiplication->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testRound()
    {
        $number = Multiplication::of(
            Real::of(2.22),
            Real::of(3),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $multiplication = Multiplication::of(
            Real::of(2.22),
            Real::of(3),
        );
        $number = $multiplication->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $multiplication = Multiplication::of(
            Real::of(2.22),
            Real::of(3),
        );
        $number = $multiplication->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $multiplication = Multiplication::of(
            Real::of(3),
            Real::of(3),
        );
        $number = $multiplication->modulo(Real::of(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $multiplication = Multiplication::of(
            Real::of(-3),
            Real::of(3),
        );
        $number = $multiplication->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $multiplication = Multiplication::of(
            Real::of(-3),
            Real::of(3),
        );
        $number = $multiplication->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $multiplication = Multiplication::of(
            Real::of(2),
            Real::of(2),
        );
        $number = $multiplication->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Multiplication::of(
            Real::of(2),
            Real::of(2),
        )->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Multiplication::of(
            Real::of(2),
            Real::of(2),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Multiplication::of(
            Real::of(2),
            Real::of(2),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Multiplication::of(
            Real::of(2),
            Real::of(2),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Multiplication::of(
            Real::of(2),
            Real::of(2),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $multiplication = Multiplication::of(
            Addition::of(
                Real::of(12),
                Real::of(12),
            ),
            Real::of(42),
            Real::of(66),
        );

        $this->assertSame('(12 + 12) x 42 x 66', $multiplication->toString());
    }

    public function testDistributivity()
    {
        //a(b+c) === ab + ac
        $this->assertTrue(
            ($a = Real::of(2))
                ->multiplyBy(
                    ($b = Real::of(3))->add($c = Real::of(4)),
                )
                ->equals(
                    $a
                        ->multiplyBy($b)
                        ->add($a->multiplyBy($c)),
                ),
        );
    }

    public function testDoubleDistributivity()
    {
        //(a+b)(c+d) === ac + ad + bc + bd
        $this->assertTrue(
            ($a = Real::of(2))
                ->add($b = Real::of(3))
                ->multiplyBy(
                    ($c = Real::of(4))->add($d = Real::of(5)),
                )
                ->equals(
                    $a
                        ->multiplyBy($c)
                        ->add($a->multiplyBy($d))
                        ->add($b->multiplyBy($c))
                        ->add($b->multiplyBy($d)),
                ),
        );
    }

    public function testRemarkableIdentity()
    {
        //(a+b)^2 = a^2 + 2ab + b^2
        $this->assertTrue(
            ($a = Real::of(2))
                ->add($b = Real::of(3))
                ->power(Real::of(2))
                ->equals(
                    $a
                        ->power(Real::of(2))
                        ->add(
                            (Real::of(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b),
                        )
                        ->add($b->power(Real::of(2))),
                ),
        );

        //(a-b)^2 = a^2 - 2ab + b^2
        $this->assertTrue(
            ($a = Real::of(2))
                ->subtract($b = Real::of(3))
                ->power(Real::of(2))
                ->equals(
                    $a
                        ->power(Real::of(2))
                        ->subtract(
                            (Real::of(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b),
                        )
                        ->add($b->power(Real::of(2))),
                ),
        );

        //(a+b)(a-b) = a^2 - b^2
        $this->assertTrue(
            ($a = Real::of(2))
                ->add($b = Real::of(3))
                ->multiplyBy($a->subtract($b))
                ->equals(
                    $a
                        ->power(Real::of(2))
                        ->subtract($b->power(Real::of(2))),
                ),
        );
    }

    public function testCollapse()
    {
        $this->assertSame(
            3,
            Real::of(3)
                ->divideBy(Real::of(2))
                ->multiplyBy(Real::of(2))
                ->collapse()
                ->value(),
        );
        $this->assertSame(
            3,
            Real::of(2)
                ->multiplyBy(
                    Real::of(3)->divideBy(Real::of(2)),
                )
                ->collapse()
                ->value(),
        );
    }
}
