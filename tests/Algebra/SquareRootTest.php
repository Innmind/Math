<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SquareRootTest extends TestCase
{
    public function testInterface()
    {
        $sqrt = Number::of(42.42)->squareRoot();

        $this->assertInstanceOf(Number::class, $sqrt);
    }

    public function testResult()
    {
        $sqrt = Number::of(4)->squareRoot();

        $this->assertSame(2.0, $sqrt->value());
    }

    public function testValue()
    {
        $sqrt = Number::of(4)->squareRoot();

        $this->assertSame(2.0, $sqrt->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '√4',
            Number::of(4)->squareRoot()->toString(),
        );
    }

    public function testEquals()
    {
        $sqrt = Number::of(4)->squareRoot();

        $this->assertTrue($sqrt->equals(Number::of(2)));
        $this->assertFalse($sqrt->equals(Number::of(4.1)));
    }

    public function testHigherThan()
    {
        $sqrt = Number::of(4)->squareRoot();

        $this->assertTrue($sqrt->higherThan(Number::of(0)));
        $this->assertFalse($sqrt->higherThan(Number::of(4)));
    }

    public function testAdd()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->add(Number::of(7));

        $this->assertSame(9.0, $number->value());
    }

    public function testSubtract()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->subtract(Number::of(7));

        $this->assertSame(-5.0, $number->value());
    }

    public function testMultiplication()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->multiplyBy(Number::of(2));

        $this->assertSame(4.0, $number->value());
    }

    public function testDivision()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->divideBy(Number::of(2));

        $this->assertSame(1.0, $number->value());
    }

    public function testFloor()
    {
        $sqrt = Number::of(2)->squareRoot();
        $number = $sqrt->floor();

        $this->assertSame(1.0, $number->value());
    }

    public function testCeil()
    {
        $sqrt = Number::of(2)->squareRoot();
        $number = $sqrt->ceil();

        $this->assertSame(2.0, $number->value());
    }

    public function testAbsolute()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->absolute();

        $this->assertSame(2.0, $number->value());
    }

    public function testModulo()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->modulo(Number::of(2));

        $this->assertSame(0.0, $number->value());
    }

    public function testPower()
    {
        $sqrt = Number::of(4)->squareRoot();
        $number = $sqrt->power(Number::of(2));

        $this->assertSame(4.0, $number->value());
    }

    public function testSquareRoot()
    {
        $sqrt = Number::of(16)->squareRoot();
        $number = $sqrt->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(16)->squareRoot()->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(16)->squareRoot()->signum();

        $this->assertSame(1, $number->value());
    }

    public function testSquareOfSquareRoot()
    {
        //sqrt(a)^2 === a
        $this->assertTrue(
            ($a = Number::of(9))
                ->squareRoot()
                ->power(Number::of(2))
                ->equals($a),
        );
    }

    public function testSquareRootOfMultiplication()
    {
        //sqrt(a*b) === sqrt(a) * sqrt(b)
        $this->assertTrue(
            ($a = Number::of(4))
                ->multiplyBy($b = Number::of(9))
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
            ($a = Number::of(4))
                ->divideBy($b = Number::of(9))
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
            ($a = Number::of(9))
                ->multiplyBy($n = Number::of(2))
                ->squareRoot()
                ->add(
                    ($b = Number::of(4))
                        ->multiplyBy($n)
                        ->squareRoot(),
                )
                ->equals(
                    $a
                        ->squareRoot()
                        ->add(
                            $b->squareRoot(),
                        )
                        ->power(Number::of(2))
                        ->multiplyBy($n)
                        ->squareRoot(),
                ),
        );
    }

    public function testSquareRootAsPowerNotation()
    {
        //sqrt(a) === a^0.5
        $this->assertTrue(
            ($a = Number::of(4))
                ->squareRoot()
                ->equals(
                    $a->power(Number::of(0.5)),
                ),
        );
    }

    public function testCollapseSquare()
    {
        $result = Number::of(2)
            ->power(Number::of(2))
            ->squareRoot()
            ->collapse()
            ->value();

        $this->assertSame(2, $result);

        $result = Number::of(2)
            ->power(Number::of(2))
            ->squareRoot()
            ->power(Number::of(2))
            ->squareRoot()
            ->collapse()
            ->value();

        $this->assertSame(2, $result);
    }
}
