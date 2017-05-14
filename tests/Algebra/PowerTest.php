<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Power,
    NumberInterface,
    OperationInterface,
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
    CommonLogarithm
};
use PHPUnit\Framework\TestCase;

class PowerTest extends TestCase
{
    public function testInterface()
    {
        $power = new Power(
            $this->createMock(NumberInterface::class),
            $this->createMock(NumberInterface::class)
        );

        $this->assertInstanceOf(NumberInterface::class, $power);
        $this->assertInstanceOf(OperationInterface::class, $power);
    }

    public function testResult()
    {
        $power = new Power(
            new Number(42.24),
            new Number(2.1)
        );
        $result = $power->result();

        $this->assertInstanceOf(NumberInterface::class, $result);
        $this->assertSame(2594.3000857236, $result->value());
        $this->assertSame($result, $power->result());
    }

    public function testStringCast()
    {
        $power = new Power(
            new Number(42.24),
            new Number(2.1)
        );

        $this->assertSame('42.24^2.1', (string) $power);
    }

    public function testStringCastOperations()
    {
        $power = new Power(
            new Addition(
                new Number(1),
                new Number(1)
            ),
            new Addition(
                new Number(2),
                new Number(2)
            )
        );

        $this->assertSame('(1 + 1)^(2 + 2)', (string) $power);
    }

    public function testEquals()
    {
        $power = new Power(
            new Number(2),
            new Number(2.1)
        );

        $this->assertTrue($power->equals(new Number(4.2870938501451725)));
        $this->assertFalse($power->equals(new Number(4)));
    }

    public function testHigherThan()
    {
        $power = new Power(
            new Number(2),
            new Number(2.1)
        );

        $this->assertTrue($power->higherThan(new Number(4.28709385)));
        $this->assertFalse($power->higherThan(new Number(4.2870938501451725)));
    }

    public function testAdd()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testFloor()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->modulo(new Number(0.5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $power = new Power(
            new Number(-2),
            new Number(3)
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testPower()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $power = new Power(
            new Number(2),
            new Number(2)
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Power(
            new Number(2),
            new Number(2)
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Power(
            new Number(2),
            new Number(2)
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Power(
            new Number(2),
            new Number(2)
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Power(
            new Number(2),
            new Number(2)
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(log10(4), $number->value());
    }

    public function testNegativePower()
    {
        //a^-n === 1/(a^n)
        $this->assertTrue(
            ($a = new Number(2))
                ->power($n = new Number(-3))
                ->equals(
                    (new Number(1))->divideBy(
                        $a->power(
                            $n->absolute()
                        )
                    )
                )
        );
    }

    public function testPowerAddition()
    {
        //x^(a+b) === x^a + x^b
        $this->assertTrue(
            ($x = new Number(2))
                ->power(
                    ($a = new Number(3))->add($b = new Number(4))
                )
                ->equals(
                    $x
                        ->power($a)
                        ->multiplyBy(
                            $x->power($b)
                        )
                )
        );
    }

    public function testPowerSubtraction()
    {
        //x^(a-b) === x^a / x^b
        $this->assertTrue(
            ($x = new Number(2))
                ->power(
                    ($a = new Number(3))->subtract($b = new Number(4))
                )
                ->equals(
                    $x
                        ->power($a)
                        ->divideBy(
                            $x->power($b)
                        )
                )
        );
    }

    public function testPowerMultiplication()
    {
        //(x^a)^b === x^(a*b)
        $this->assertTrue(
            ($x = new Number(2))
                ->power($a = new Number(3))
                ->power($b = new Number(4))
                ->equals(
                    $x->power(
                        $a->multiplyBy($b)
                    )
                )
        );
    }

    public function testPowerDistribution()
    {
        //(a*b)^n = a^n * b^n
        $this->assertTrue(
            ($a = new Number(2))
                ->multiplyBy($b = new Number(3))
                ->power($n = new Number(4))
                ->equals(
                    $a
                        ->power($n)
                        ->multiplyBy(
                            $b->power($n)
                        )
                )
        );
    }
}
