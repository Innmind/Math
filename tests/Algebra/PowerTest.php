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
    Signum
};
use PHPUnit\Framework\TestCase;

class PowerTest extends TestCase
{
    public function testInterface()
    {
        $power = new Power(
            $this->createMock(Number::class),
            $this->createMock(Number::class),
        );

        $this->assertInstanceOf(Number::class, $power);
        $this->assertInstanceOf(Operation::class, $power);
    }

    public function testResult()
    {
        $power = new Power(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );
        $result = $power->result();

        $this->assertInstanceOf(Number::class, $result);
        $this->assertSame(2594.300085723648, $result->value());
    }

    public function testStringCast()
    {
        $power = new Power(
            new Number\Number(42.24),
            new Number\Number(2.1),
        );

        $this->assertSame('42.24^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = new Power(
            new Addition(
                new Number\Number(1),
                new Number\Number(1),
            ),
            new Addition(
                new Number\Number(2),
                new Number\Number(2),
            ),
        );

        $this->assertSame('(1 + 1)^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2.1),
        );

        $this->assertTrue($power->equals(new Number\Number(4.2870938501451725)));
        $this->assertFalse($power->equals(new Number\Number(4)));
    }

    public function testHigherThan()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2.1),
        );

        $this->assertTrue($power->higherThan(new Number\Number(4.28709385)));
        $this->assertFalse($power->higherThan(new Number\Number(4.2870938501451725)));
    }

    public function testAdd()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->add(new Number\Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->modulo(new Number\Number(0.5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $power = new Power(
            new Number\Number(-2),
            new Number\Number(3),
        );
        $number = $power->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testPower()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $power = new Power(
            new Number\Number(2),
            new Number\Number(2),
        );
        $number = $power->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new Power(
            new Number\Number(2),
            new Number\Number(2),
        ))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Power(
            new Number\Number(2),
            new Number\Number(2),
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Power(
            new Number\Number(2),
            new Number\Number(2),
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Power(
            new Number\Number(2),
            new Number\Number(2),
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = (new Power(
            new Number\Number(2),
            new Number\Number(2),
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testNegativePower()
    {
        //a^-n === 1/(a^n)
        $this->assertTrue(
            ($a = new Number\Number(2))
                ->power($n = new Number\Number(-3))
                ->equals(
                    (new Number\Number(1))->divideBy(
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
            ($x = new Number\Number(2))
                ->power(
                    ($a = new Number\Number(3))->add($b = new Number\Number(4)),
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
            ($x = new Number\Number(2))
                ->power(
                    ($a = new Number\Number(3))->subtract($b = new Number\Number(4)),
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
            ($x = new Number\Number(2))
                ->power($a = new Number\Number(3))
                ->power($b = new Number\Number(4))
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
            ($a = new Number\Number(2))
                ->multiplyBy($b = new Number\Number(3))
                ->power($n = new Number\Number(4))
                ->equals(
                    $a
                        ->power($n)
                        ->multiplyBy(
                            $b->power($n),
                        ),
                ),
        );
    }
}
