<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Tangent,
    Geometry\Angle\Degree,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)));

        $this->assertSame(0.9004040442978399, $tan->number()->value());
        $this->assertSame('tan(42°)', $tan->toString());
    }

    public function testEquals()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();

        $this->assertTrue($tan->equals($tan));
        $this->assertTrue($tan->equals(Number::of(0.9004040442978399)));
        $this->assertFalse($tan->equals(Number::of(0.9)));
    }

    public function testHigherThan()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();

        $this->assertFalse($tan->higherThan($tan));
        $this->assertFalse($tan->higherThan(Number::of(0.9004040442978399)));
        $this->assertTrue($tan->higherThan(Number::of(0.9)));
    }

    public function testAdd()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->add(Number::of(1));

        $this->assertSame(1.90040404429784, $number->value());
    }

    public function testSubtract()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->subtract(Number::of(66));

        $this->assertSame(-65.09959595570216, $number->value());
    }

    public function testDivideBy()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->divideBy(Number::of(2));

        $this->assertSame(0.45020202214891997, $number->value());
    }

    public function testMulitplyBy()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->multiplyBy(Number::of(2));

        $this->assertSame(1.8008080885956799, $number->value());
    }

    public function testRound()
    {
        $number = Tangent::of(Degree::of(Number::of(42)))->number();

        $this->assertEquals(0.9, $number->roundUp(1)->value());
        $this->assertEquals(0.9, $number->roundDown(1)->value());
        $this->assertEquals(0.9, $number->roundEven(1)->value());
        $this->assertEquals(0.9, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->ceil();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->modulo(Number::of(3));

        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testAbsolute()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->absolute();

        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testPower()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->power(Number::of(2));

        $this->assertSame(0.8107274429879064, $number->value());
    }

    public function testSquareRoot()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->squareRoot();

        $this->assertSame(0.9488962241983261, $number->value());
    }

    public function testExponential()
    {
        $tan = Tangent::of(Degree::of(Number::of(42)))->number();
        $number = $tan->exponential();

        $this->assertSame(2.4605971005633154, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Tangent::of(Degree::of(Number::of(42)))
            ->number()
            ->binaryLogarithm();

        $this->assertSame(-0.1513555580027417, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Tangent::of(Degree::of(Number::of(42)))
            ->number()
            ->naturalLogarithm();

        $this->assertSame(-0.10491167829167766, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Tangent::of(Degree::of(Number::of(42)))
            ->number()
            ->commonLogarithm();

        $this->assertEqualsWithDelta(
            -0.04556256296928478,
            $number->value(),
            0.00000000000000001,
        );
    }

    public function testSignum()
    {
        $number = Tangent::of(Degree::of(Number::of(42)))
            ->number()
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
