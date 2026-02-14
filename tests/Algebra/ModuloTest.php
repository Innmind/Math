<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\Number;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ModuloTest extends TestCase
{
    public function testInterface()
    {
        $modulo = Number::one()->modulo(Number::one());

        $this->assertInstanceOf(Number::class, $modulo);
    }

    public function testResult()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );

        $this->assertEqualsWithDelta(0.24, $modulo->value(), 0.0001);
    }

    public function testStringCast()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );

        $this->assertSame('42.24 % 2.1', $modulo->toString());
    }

    public function testStringCastOperations()
    {
        $modulo = Number::of(1)
            ->add(Number::of(1))
            ->modulo(
                Number::of(2)->add(Number::of(2)),
            );

        $this->assertSame('(1 + 1) % (2 + 2)', $modulo->toString());
    }

    public function testEquals()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );

        $this->assertTrue($modulo->equals(Number::of(0.2400000000000002)));
        $this->assertFalse($modulo->equals(Number::of(1.24)));
    }

    public function testHigherThan()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );

        $this->assertTrue($modulo->higherThan(Number::of(0.23)));
        $this->assertFalse($modulo->higherThan(Number::of(0.2400000000000002)));
    }

    public function testAdd()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->add(Number::of(66));

        $this->assertSame(66.24, $number->value());
    }

    public function testSubtract()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->subtract(Number::of(66));

        $this->assertSame(-65.76, $number->value());
    }

    public function testDivideBy()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->divideBy(Number::of(2));

        $this->assertEqualsWithDelta(
            0.12,
            $number->value(),
            0.001,
        );
    }

    public function testMulitplyBy()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->multiplyBy(Number::of(2));

        $this->assertEqualsWithDelta(0.48, $number->value(), 0.0001);
    }

    public function testFloor()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->ceil();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $modulo = Number::of(42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->modulo(Number::of(0.1));

        $this->assertEqualsWithDelta(
            0.04,
            $number->value(),
            0.001,
        );
    }

    public function testAbsolute()
    {
        $modulo = Number::of(-42.24)->modulo(
            Number::of(2.1),
        );
        $number = $modulo->absolute();

        $this->assertEqualsWithDelta(0.24, $number->value(), 0.00001);
    }

    public function testPower()
    {
        $modulo = Number::of(9)->modulo(
            Number::of(2),
        );
        $number = $modulo->power(Number::of(2));

        $this->assertSame(1.0, $number->value());
    }

    public function testSquareRoot()
    {
        $modulo = Number::of(12)->modulo(
            Number::of(8),
        );
        $number = $modulo->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Number::of(12)
            ->modulo(Number::of(8))
            ->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testSignum()
    {
        $number = Number::of(12)
            ->modulo(Number::of(8))
            ->signum();

        $this->assertSame(1, $number->value());
    }

    private function assertEqualsWithDelta(
        int|float $expected,
        int|float $value,
        int|float $delta,
    ): void {
        $this->assertGreaterThanOrEqual($expected-$delta, $value);
        $this->assertLessThanOrEqual($expected+$delta, $value);
    }
}
