<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    SquareRoot,
    Ceil,
    Floor,
    NumberInterface,
    OperationInterface,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Modulo,
    Absolute,
    Power,
    Exponential
};
use PHPUnit\Framework\TestCase;

class SquareRootTest extends TestCase
{
    public function testInterface()
    {
        $sqrt = new SquareRoot(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $sqrt);
        $this->assertInstanceOf(OperationInterface::class, $sqrt);
    }

    public function testResult()
    {
        $sqrt = new SquareRoot(new Number(4));
        $result = $sqrt->result();

        $this->assertInstanceOf(NumberInterface::class, $result);
        $this->assertSame(2.0, $result->value());
        $this->assertSame($result, $sqrt->result());
    }

    public function testValue()
    {
        $sqrt = new SquareRoot(new Number(4));

        $this->assertSame(2.0, $sqrt->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '√4',
            (string) new SquareRoot(new Number(4))
        );
    }

    public function testEquals()
    {
        $sqrt = new SquareRoot(new Number(4));

        $this->assertTrue($sqrt->equals(new Number(2)));
        $this->assertFalse($sqrt->equals(new Number(4.1)));
    }

    public function testHigherThan()
    {
        $sqrt = new SquareRoot(new Number(4));

        $this->assertTrue($sqrt->higherThan(new Number(0)));
        $this->assertFalse($sqrt->higherThan(new Number(4)));
    }

    public function testAdd()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testSubtract()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-5.0, $number->value());
    }

    public function testMultiplication()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testDivision()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testRound()
    {
        $sqrt = new SquareRoot(new Number(2));
        $number = $sqrt->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testFloor()
    {
        $sqrt = new SquareRoot(new Number(2));
        $number = $sqrt->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testCeil()
    {
        $sqrt = new SquareRoot(new Number(2));
        $number = $sqrt->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testModulo()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $sqrt = new SquareRoot(new Number(4));
        $number = $sqrt->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testSquareRoot()
    {
        $sqrt = new SquareRoot(new Number(16));
        $number = $sqrt->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = (new SquareRoot(new Number(16)))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(exp(4), $number->value());
    }

    public function testSquareOfSquareRoot()
    {
        //sqrt(a)^2 === a
        $this->assertTrue(
            ($a = new Number(9))
                ->squareRoot()
                ->power(new Number(2))
                ->equals($a)
        );
    }

    public function testSquareRootOfMultiplication()
    {
        //sqrt(a*b) === sqrt(a) * sqrt(b)
        $this->assertTrue(
            ($a = new Number(4))
                ->multiplyBy($b = new Number(9))
                ->squareRoot()
                ->equals(
                    $a
                        ->squareRoot()
                        ->multiplyBy(
                            $b->squareRoot()
                        )
                )
        );
    }

    public function testSquareRootOfDivision()
    {
        //sqrt(a/b) === sqrt(a) / sqrt(b)
        $this->assertTrue(
            ($a = new Number(4))
                ->divideBy($b = new Number(9))
                ->squareRoot()
                ->equals(
                    $a
                        ->squareRoot()
                        ->divideBy(
                            $b->squareRoot()
                        )
                )
        );
    }

    public function testSquareRootAddition()
    {
        //sqrt(a*n) + sqrt(b*n) === sqrt((sqrt(a) + sqrt(b))^2 * n)
        $this->assertTrue(
            ($a = new Number(9))
                ->multiplyBy($n = new Number(2))
                ->squareRoot()
                ->add(
                    ($b = new Number(4))
                        ->multiplyBy($n)
                        ->squareRoot()
                )
                ->equals(
                    $a
                        ->squareRoot()
                        ->add(
                            $b->squareRoot()
                        )
                        ->power(new Number(2))
                        ->multiplyBy($n)
                        ->squareRoot()
                )
        );
    }

    public function testSquareRootAsPowerNotation()
    {
        //sqrt(a) === a^0.5
        $this->assertTrue(
            ($a = new Number(4))
                ->squareRoot()
                ->equals(
                    $a->power(new Number(0.5))
                )
        );
    }
}
