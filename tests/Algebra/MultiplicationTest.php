<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
{
    public function testInterface()
    {
        $multiplication = Number::of(4)->multiplyBy(
            Number::of(42),
        );

        $this->assertInstanceOf(Number::class, $multiplication);
        $this->assertSame('4 x 42', $multiplication->toString());
    }

    public function testResult()
    {
        $multiplication = Number::of(42)->multiplyBy(
            Number::of(24),
        );

        $this->assertInstanceOf(Number::class, $multiplication);
        $this->assertSame(1008, $multiplication->value());
    }

    public function testValue()
    {
        $multiplication = Number::of(4)->multiplyBy(
            Number::of(2),
        );

        $this->assertSame(8, $multiplication->value());
    }

    public function testEquals()
    {
        $multiplication = Number::of(4)->multiplyBy(
            Number::of(2),
        );

        $this->assertTrue($multiplication->equals(Number::of(8)));
        $this->assertFalse($multiplication->equals(Number::of(8.1)));
    }

    public function testHigherThan()
    {
        $multiplication = Number::of(4)->multiplyBy(
            Number::of(2),
        );

        $this->assertFalse($multiplication->higherThan(Number::of(8)));
        $this->assertTrue($multiplication->higherThan(Number::of(7.9)));
    }

    public function testAdd()
    {
        $multiplication = Number::of(4)->multiplyBy(
            Number::of(2),
        );
        $number = $multiplication->add(Number::of(66));

        $this->assertSame(74, $number->value());
    }

    public function testSubtract()
    {
        $multiplication = Number::of(4)->multiplyBy(
            Number::of(2),
        );
        $number = $multiplication->subtract(Number::of(66));

        $this->assertSame(-58, $number->value());
    }

    public function testDivideBy()
    {
        $multiplication = Number::of(4.5)->multiplyBy(
            Number::of(2),
        );
        $number = $multiplication->divideBy(Number::of(3));

        $this->assertSame(3.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $multiplication = Number::of(24)->add(
            Number::of(42),
        );
        $number = $multiplication->multiplyBy(Number::of(2));

        $this->assertSame(132, $number->value());
    }

    public function testFloor()
    {
        $multiplication = Number::of(2.22)->multiplyBy(
            Number::of(3),
        );
        $number = $multiplication->floor();

        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $multiplication = Number::of(2.22)->multiplyBy(
            Number::of(3),
        );
        $number = $multiplication->ceil();

        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $multiplication = Number::of(3)->multiplyBy(
            Number::of(3),
        );
        $number = $multiplication->modulo(Number::of(2));

        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $multiplication = Number::of(-3)->multiplyBy(
            Number::of(3),
        );
        $number = $multiplication->absolute();

        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $multiplication = Number::of(-3)->multiplyBy(
            Number::of(3),
        );
        $number = $multiplication->power(Number::of(2));

        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $multiplication = Number::of(2)->multiplyBy(
            Number::of(2),
        );
        $number = $multiplication->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(2)
            ->multiplyBy(Number::of(2))
            ->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(2)
            ->multiplyBy(Number::of(2))
            ->signum();

        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $multiplication = Number::of(12)
            ->add(Number::of(12))
            ->multiplyBy(Number::of(42))
            ->multiplyBy(Number::of(66));

        $this->assertSame('(12 + 12) x 42 x 66', $multiplication->toString());
    }

    public function testDistributivity()
    {
        //a(b+c) === ab + ac
        $this->assertTrue(
            ($a = Number::of(2))
                ->multiplyBy(
                    ($b = Number::of(3))->add($c = Number::of(4)),
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
            ($a = Number::of(2))
                ->add($b = Number::of(3))
                ->multiplyBy(
                    ($c = Number::of(4))->add($d = Number::of(5)),
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
            ($a = Number::of(2))
                ->add($b = Number::of(3))
                ->power(Number::of(2))
                ->equals(
                    $a
                        ->power(Number::of(2))
                        ->add(
                            (Number::of(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b),
                        )
                        ->add($b->power(Number::of(2))),
                ),
        );

        //(a-b)^2 = a^2 - 2ab + b^2
        $this->assertTrue(
            ($a = Number::of(2))
                ->subtract($b = Number::of(3))
                ->power(Number::of(2))
                ->equals(
                    $a
                        ->power(Number::of(2))
                        ->subtract(
                            (Number::of(2))
                                ->multiplyBy($a)
                                ->multiplyBy($b),
                        )
                        ->add($b->power(Number::of(2))),
                ),
        );

        //(a+b)(a-b) = a^2 - b^2
        $this->assertTrue(
            ($a = Number::of(2))
                ->add($b = Number::of(3))
                ->multiplyBy($a->subtract($b))
                ->equals(
                    $a
                        ->power(Number::of(2))
                        ->subtract($b->power(Number::of(2))),
                ),
        );
    }

    public function testCollapse()
    {
        $this->assertSame(
            3,
            Number::of(3)
                ->divideBy(Number::of(2))
                ->multiplyBy(Number::of(2))
                ->optimize()
                ->value(),
        );
        $this->assertSame(
            3,
            Number::of(2)
                ->multiplyBy(
                    Number::of(3)->divideBy(Number::of(2)),
                )
                ->optimize()
                ->value(),
        );
    }
}
