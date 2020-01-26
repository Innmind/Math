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
    Signum
};
use PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
{
    public function testInterface()
    {
        $multiplication = new Multiplication(
            new Number\Number(4),
            new Number\Number(42)
        );

        $this->assertInstanceOf(Operation::class, $multiplication);
        $this->assertInstanceOf(Number::class, $multiplication);
        $this->assertSame('4 x 42', $multiplication->toString());
    }

    public function testResult()
    {
        $multiplication = new Multiplication(
            new Number\Number(42),
            new Number\Number(24)
        );
        $result = $multiplication->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(1008, $result->value());
        $this->assertTrue($result->equals($multiplication->product()));
        $this->assertSame($result, $multiplication->result());
    }

    public function testValue()
    {
        $multiplication = new Multiplication(
            new Number\Number(4),
            new Number\Number(2)
        );

        $this->assertSame(8, $multiplication->value());
    }

    public function testEquals()
    {
        $multiplication = new Multiplication(
            new Number\Number(4),
            new Number\Number(2)
        );

        $this->assertTrue($multiplication->equals(new Number\Number(8)));
        $this->assertFalse($multiplication->equals(new Number\Number(8.1)));
    }

    public function testHigherThan()
    {
        $multiplication = new Multiplication(
            new Number\Number(4),
            new Number\Number(2)
        );

        $this->assertFalse($multiplication->higherThan(new Number\Number(8)));
        $this->assertTrue($multiplication->higherThan(new Number\Number(7.9)));
    }

    public function testAdd()
    {
        $multiplication = new Multiplication(
            new Number\Number(4),
            new Number\Number(2)
        );
        $number = $multiplication->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(74, $number->value());
    }

    public function testSubtract()
    {
        $multiplication = new Multiplication(
            new Number\Number(4),
            new Number\Number(2)
        );
        $number = $multiplication->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-58, $number->value());
    }

    public function testDivideBy()
    {
        $multiplication = new Multiplication(
            new Number\Number(4.5),
            new Number\Number(2)
        );
        $number = $multiplication->divideBy(new Number\Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $multiplication = new Addition(
            new Number\Number(24),
            new Number\Number(42)
        );
        $number = $multiplication->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testRound()
    {
        $multiplication = new Multiplication(
            new Number\Number(2.22),
            new Number\Number(3)
        );
        $number = $multiplication->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(6.7, $number->value());
    }

    public function testFloor()
    {
        $multiplication = new Multiplication(
            new Number\Number(2.22),
            new Number\Number(3)
        );
        $number = $multiplication->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $multiplication = new Multiplication(
            new Number\Number(2.22),
            new Number\Number(3)
        );
        $number = $multiplication->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $multiplication = new Multiplication(
            new Number\Number(3),
            new Number\Number(3)
        );
        $number = $multiplication->modulo(new Number\Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $multiplication = new Multiplication(
            new Number\Number(-3),
            new Number\Number(3)
        );
        $number = $multiplication->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $multiplication = new Multiplication(
            new Number\Number(-3),
            new Number\Number(3)
        );
        $number = $multiplication->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $multiplication = new Multiplication(
            new Number\Number(2),
            new Number\Number(2)
        );
        $number = $multiplication->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Multiplication(
            new Number\Number(2),
            new Number\Number(2)
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Multiplication(
            new Number\Number(2),
            new Number\Number(2)
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Multiplication(
            new Number\Number(2),
            new Number\Number(2)
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Multiplication(
            new Number\Number(2),
            new Number\Number(2)
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Multiplication(
            new Number\Number(2),
            new Number\Number(2)
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $multiplication = new Multiplication(
            new Addition(
                new Number\Number(12),
                new Number\Number(12)
            ),
            new Number\Number(42),
            new Number\Number(66)
        );

        $this->assertSame('(12 + 12) x 42 x 66', $multiplication->toString());
    }

    public function testDistributivity()
    {
        //a(b+c) === ab + ac
        $this->assertTrue(
            ($a = new Number\Number(2))
                ->multiplyBy(
                    ($b = new Number\Number(3))->add($c = new Number\Number(4))
                )
                ->equals(
                    $a
                        ->multiplyBy($b)
                        ->add($a->multiplyBy($c))
                )
        );
    }

    public function testDoubleDistributivity()
    {
        //(a+b)(c+d) === ac + ad + bc + bd
        $this->assertTrue(
            ($a = new Number\Number(2))
                ->add($b = new Number\Number(3))
                ->multiplyBy(
                    ($c = new Number\Number(4))->add($d = new Number\Number(5))
                )
                ->equals(
                    $a
                        ->multiplyBy($c)
                        ->add($a->multiplyBy($d))
                        ->add($b->multiplyBy($c))
                        ->add($b->multiplyBy($d))
                )
        );
    }

    public function testRemarkableIdentity()
    {
        //(a+b)^2 = a^2 + 2ab + b^2
        $this->assertTrue(
            ($a = new Number\Number(2))
                ->add($b = new Number\Number(3))
                ->power(new Number\Number(2))
                ->equals(
                    $a
                        ->power(new Number\Number(2))
                        ->add(
                            (new Number\Number(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b)
                        )
                        ->add($b->power(new Number\Number(2)))
                )
        );

        //(a-b)^2 = a^2 - 2ab + b^2
        $this->assertTrue(
            ($a = new Number\Number(2))
                ->subtract($b = new Number\Number(3))
                ->power(new Number\Number(2))
                ->equals(
                    $a
                        ->power(new Number\Number(2))
                        ->subtract(
                            (new Number\Number(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b)
                        )
                        ->add($b->power(new Number\Number(2)))
                )
        );

        //(a+b)(a-b) = a^2 - b^2
        $this->assertTrue(
            ($a = new Number\Number(2))
                ->add($b = new Number\Number(3))
                ->multiplyBy($a->subtract($b))
                ->equals(
                    $a
                        ->power(new Number\Number(2))
                        ->subtract($b->power(new Number\Number(2)))
                )
        );
    }
}
