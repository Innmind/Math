<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Logarithm,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SineTest extends TestCase
{
    public function testInterface()
    {
        $sin = Degree::of(Number::of(42))->sine();

        $this->assertSame(0.6691306063588582, $sin->value());
        $this->assertSame('sin(42°)', $sin->toString());
    }

    public function testEquals()
    {
        $sin = Degree::of(Number::of(42))->sine();

        $this->assertTrue($sin->equals($sin));
        $this->assertTrue($sin->equals(Number::of(0.6691306063588582)));
        $this->assertFalse($sin->equals(Number::of(0.66)));
    }

    public function testHigherThan()
    {
        $sin = Degree::of(Number::of(42))->sine();

        $this->assertFalse($sin->higherThan($sin));
        $this->assertFalse($sin->higherThan(Number::of(0.6691306063588582)));
        $this->assertTrue($sin->higherThan(Number::of(0.66)));
    }

    public function testAdd()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->add(Number::of(1));

        $this->assertSame(1.6691306063588582, $number->value());
    }

    public function testSubtract()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->subtract(Number::of(66));

        $this->assertSame(-65.33086939364114, $number->value());
    }

    public function testDivideBy()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->divideBy(Number::of(2));

        $this->assertSame(0.3345653031794291, $number->value());
    }

    public function testMulitplyBy()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->multiplyBy(Number::of(2));

        $this->assertSame(1.3382612127177165, $number->value());
    }

    public function testRound()
    {
        $number = Degree::of(Number::of(42))->sine();

        $this->assertEquals(0.7, $number->roundUp(1)->value());
        $this->assertEquals(0.7, $number->roundDown(1)->value());
        $this->assertEquals(0.7, $number->roundEven(1)->value());
        $this->assertEquals(0.7, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->floor();

        $this->assertSame(0, $number->value());
    }

    public function testCeil()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->ceil();

        $this->assertSame(1, $number->value());
    }

    public function testModulo()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->modulo(Number::of(3));

        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testAbsolute()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->absolute();

        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testPower()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->power(Number::of(2));

        $this->assertSame(0.4477357683661733, $number->value());
    }

    public function testSquareRoot()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->squareRoot();

        $this->assertSame(0.8180040381066943, $number->value());
    }

    public function testExponential()
    {
        $sin = Degree::of(Number::of(42))->sine();
        $number = $sin->exponential();

        $this->assertSame(1.9525390574726629, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->sine()
            ->apply(Logarithm::binary);

        $this->assertSame(-0.5796402595724052, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->sine()
            ->apply(Logarithm::natural);

        $this->assertSame(-0.4017760116616475, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->sine()
            ->apply(Logarithm::common);

        $this->assertSame(-0.17448910482575006, $number->value());
    }

    public function testSignum()
    {
        $number = Degree::of(Number::of(42))
            ->sine()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
