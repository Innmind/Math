<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PowerTest extends TestCase
{
    public function testInterface()
    {
        $power = Number::one()->power(
            Number::one(),
        );

        $this->assertInstanceOf(Number::class, $power);
    }

    public function testResult()
    {
        $power = Number::of(42.24)->power(
            Number::of(2.1),
        );

        $this->assertSame(2594.300085723648, $power->value());
    }

    public function testStringCast()
    {
        $power = Number::of(42.24)->power(
            Number::of(2.1),
        );

        $this->assertSame('42.24^2.1', $power->toString());
    }

    public function testStringCastOperations()
    {
        $power = Number::of(1)
            ->add(Number::of(1))
            ->power(
                Number::of(2)->add(Number::of(2)),
            );

        $this->assertSame('(1 + 1)^(2 + 2)', $power->toString());
    }

    public function testEquals()
    {
        $power = Number::of(2)->power(
            Number::of(2.1),
        );

        $this->assertTrue($power->equals(Number::of(4.2870938501451725)));
        $this->assertFalse($power->equals(Number::of(4)));
    }

    public function testHigherThan()
    {
        $power = Number::of(2)->power(
            Number::of(2.1),
        );

        $this->assertTrue($power->higherThan(Number::of(4.28709385)));
        $this->assertFalse($power->higherThan(Number::of(4.2870938501451725)));
    }

    public function testAdd()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->add(Number::of(66));

        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->subtract(Number::of(66));

        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->divideBy(Number::of(2));

        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->multiplyBy(Number::of(2));

        $this->assertSame(8, $number->value());
    }

    public function testFloor()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->floor();

        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->ceil();

        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->modulo(Number::of(0.5));

        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $power = Number::of(-2)->power(
            Number::of(3),
        );
        $number = $power->absolute();

        $this->assertSame(8, $number->value());
    }

    public function testPower()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->power(Number::of(2));

        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $power = Number::of(2)->power(
            Number::of(2),
        );
        $number = $power->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(2)
            ->power(Number::of(2))
            ->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)
            ->power(Number::of(2))
            ->signum();

        $this->assertSame(1, $number->value());
    }

    public function testNegativePower()
    {
        //a^-n === 1/(a^n)
        $this->assertTrue(
            ($a = Number::of(2))
                ->power($n = Number::of(-3))
                ->equals(
                    Number::of(1)->divideBy(
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
            ($x = Number::of(2))
                ->power(
                    ($a = Number::of(3))->add($b = Number::of(4)),
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
            ($x = Number::of(2))
                ->power(
                    ($a = Number::of(3))->subtract($b = Number::of(4)),
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
            ($x = Number::of(2))
                ->power($a = Number::of(3))
                ->power($b = Number::of(4))
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
            ($a = Number::of(2))
                ->multiplyBy($b = Number::of(3))
                ->power($n = Number::of(4))
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
        $result = Number::of(2)
            ->squareRoot()
            ->power(Number::of(2))
            ->optimize()
            ->value();

        $this->assertSame(2, $result);

        $result = Number::of(2)
            ->squareRoot()
            ->power(Number::of(2))
            ->squareRoot()
            ->power(Number::of(2))
            ->optimize()
            ->value();

        $this->assertSame(2, $result);
    }
}
