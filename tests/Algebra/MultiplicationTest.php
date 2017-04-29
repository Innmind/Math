<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Multiplication,
    Number,
    OperationInterface,
    NumberInterface,
    Addition,
    Subtraction,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot
};
use PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
{
    public function testInterface()
    {
        $multiplication = new Multiplication(
            $first = new Number(4),
            $second = new Number(42)
        );

        $this->assertInstanceOf(OperationInterface::class, $multiplication);
        $this->assertInstanceOf(NumberInterface::class, $multiplication);
        $this->assertInstanceOf(\Iterator::class, $multiplication);
        $this->assertSame($first, $multiplication->current());
        $this->assertSame(0, $multiplication->key());
        $this->assertTrue($multiplication->valid());
        $this->assertNull($multiplication->next());
        $this->assertSame($second, $multiplication->current());
        $this->assertSame(1, $multiplication->key());
        $multiplication->next();
        $this->assertFalse($multiplication->valid());
        $this->assertNull($multiplication->rewind());
        $this->assertSame($first, $multiplication->current());
    }

    public function testResult()
    {
        $multiplication = new Multiplication(
            new Number(42),
            new Number(24)
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
            new Number(4),
            new Number(2)
        );

        $this->assertSame(8, $multiplication->value());
    }

    public function testEquals()
    {
        $multiplication = new Multiplication(
            new Number(4),
            new Number(2)
        );

        $this->assertTrue($multiplication->equals(new Number(8)));
        $this->assertFalse($multiplication->equals(new Number(8.1)));
    }

    public function testHigherThan()
    {
        $multiplication = new Multiplication(
            new Number(4),
            new Number(2)
        );

        $this->assertFalse($multiplication->higherThan(new Number(8)));
        $this->assertTrue($multiplication->higherThan(new Number(7.9)));
    }

    public function testAdd()
    {
        $multiplication = new Multiplication(
            new Number(4),
            new Number(2)
        );
        $number = $multiplication->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(74, $number->value());
    }

    public function testSubtract()
    {
        $multiplication = new Multiplication(
            new Number(4),
            new Number(2)
        );
        $number = $multiplication->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-58, $number->value());
    }

    public function testDivideBy()
    {
        $multiplication = new Multiplication(
            new Number(4.5),
            new Number(2)
        );
        $number = $multiplication->divideBy(new Number(3));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $multiplication = new Addition(
            new Number(24),
            new Number(42)
        );
        $number = $multiplication->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(132, $number->value());
    }

    public function testRound()
    {
        $multiplication = new Multiplication(
            new Number(2.22),
            new Number(3)
        );
        $number = $multiplication->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(6.7, $number->value());
    }

    public function testFloor()
    {
        $multiplication = new Multiplication(
            new Number(2.22),
            new Number(3)
        );
        $number = $multiplication->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $multiplication = new Multiplication(
            new Number(2.22),
            new Number(3)
        );
        $number = $multiplication->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $multiplication = new Multiplication(
            new Number(3),
            new Number(3)
        );
        $number = $multiplication->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $multiplication = new Multiplication(
            new Number(-3),
            new Number(3)
        );
        $number = $multiplication->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $multiplication = new Multiplication(
            new Number(-3),
            new Number(3)
        );
        $number = $multiplication->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $multiplication = new Multiplication(
            new Number(2),
            new Number(2)
        );
        $number = $multiplication->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testStringCast()
    {
        $multiplication = new Multiplication(
            new Addition(
                new Number(12),
                new Number(12)
            ),
            new Number(42),
            new Number(66)
        );

        $this->assertSame('(12 + 12) x 42 x 66', (string) $multiplication);
    }

    public function testDistributivity()
    {
        //a(b+c) === ab + ac
        $this->assertTrue(
            ($a = new Number(2))
                ->multiplyBy(
                    ($b = new Number(3))->add($c = new Number(4))
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
            ($a = new Number(2))
                ->add($b = new Number(3))
                ->multiplyBy(
                    ($c = new Number(4))->add($d = new Number(5))
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
            ($a = new Number(2))
                ->add($b = new Number(3))
                ->power(new Number(2))
                ->equals(
                    $a
                        ->power(new Number(2))
                        ->add(
                            (new Number(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b)
                        )
                        ->add($b->power(new Number(2)))
                )
        );

        //(a-b)^2 = a^2 - 2ab + b^2
        $this->assertTrue(
            ($a = new Number(2))
                ->subtract($b = new Number(3))
                ->power(new Number(2))
                ->equals(
                    $a
                        ->power(new Number(2))
                        ->subtract(
                            (new Number(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b)
                        )
                        ->add($b->power(new Number(2)))
                )
        );

        //(a+b)(a-b) = a^2 - b^2
        $this->assertTrue(
            ($a = new Number(2))
                ->add($b = new Number(3))
                ->multiplyBy($a->subtract($b))
                ->equals(
                    $a
                        ->power(new Number(2))
                        ->subtract($b->power(new Number(2)))
                )
        );
    }
}
