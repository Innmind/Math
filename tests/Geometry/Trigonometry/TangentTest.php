<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Logarithm,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        $tan = Degree::of(Number::of(42))->tangent();

        $this->assertSame(0.9004040442978399, $tan->value());
        $this->assertSame('tan(42°)', $tan->toString());
    }

    public function testEquals()
    {
        $tan = Degree::of(Number::of(42))->tangent();

        $this->assertTrue($tan->equals($tan));
        $this->assertTrue($tan->equals(Number::of(0.9004040442978399)));
        $this->assertFalse($tan->equals(Number::of(0.9)));
    }

    public function testHigherThan()
    {
        $tan = Degree::of(Number::of(42))->tangent();

        $this->assertFalse($tan->higherThan($tan));
        $this->assertFalse($tan->higherThan(Number::of(0.9004040442978399)));
        $this->assertTrue($tan->higherThan(Number::of(0.9)));
    }

    public function testAdd()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->add(Number::of(1));

        $this->assertSame(1.90040404429784, $number->value());
    }

    public function testSubtract()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->subtract(Number::of(66));

        $this->assertSame(-65.09959595570216, $number->value());
    }

    public function testDivideBy()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->divideBy(Number::of(2));

        $this->assertSame(0.45020202214891997, $number->value());
    }

    public function testMulitplyBy()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->multiplyBy(Number::of(2));

        $this->assertSame(1.8008080885956799, $number->value());
    }

    public function testRound()
    {
        $number = Degree::of(Number::of(42))->tangent();

        $this->assertEquals(0.9, $number->roundUp(1)->value());
        $this->assertEquals(0.9, $number->roundDown(1)->value());
        $this->assertEquals(0.9, $number->roundEven(1)->value());
        $this->assertEquals(0.9, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->floor();

        $this->assertSame(0, $number->value());
    }

    public function testCeil()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->ceil();

        $this->assertSame(1, $number->value());
    }

    public function testModulo()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->modulo(Number::of(3));

        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testAbsolute()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->absolute();

        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testPower()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->power(Number::of(2));

        $this->assertSame(0.8107274429879064, $number->value());
    }

    public function testSquareRoot()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->squareRoot();

        $this->assertSame(0.9488962241983261, $number->value());
    }

    public function testExponential()
    {
        $tan = Degree::of(Number::of(42))->tangent();
        $number = $tan->exponential();

        $this->assertSame(2.4605971005633154, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->tangent()
            ->apply(Logarithm::binary);

        $this->assertSame(-0.1513555580027417, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->tangent()
            ->apply(Logarithm::natural);

        $this->assertSame(-0.10491167829167766, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->tangent()
            ->apply(Logarithm::common);

        $this->assertEqualsWithDelta(
            -0.04556256296928478,
            $number->value(),
            0.00000000000000001,
        );
    }

    public function testSignum()
    {
        $number = Degree::of(Number::of(42))
            ->tangent()
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
