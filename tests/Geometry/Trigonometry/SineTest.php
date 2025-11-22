<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SineTest extends TestCase
{
    public function testInterface()
    {
        $sin = Sine::of(Degree::of(Number::of(42)));

        $this->assertSame(0.6691306063588582, $sin->number()->value());
        $this->assertSame('sin(42°)', $sin->toString());
    }

    public function testEquals()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();

        $this->assertTrue($sin->equals($sin));
        $this->assertTrue($sin->equals(Number::of(0.6691306063588582)));
        $this->assertFalse($sin->equals(Number::of(0.66)));
    }

    public function testHigherThan()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();

        $this->assertFalse($sin->higherThan($sin));
        $this->assertFalse($sin->higherThan(Number::of(0.6691306063588582)));
        $this->assertTrue($sin->higherThan(Number::of(0.66)));
    }

    public function testAdd()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->add(Number::of(1));

        $this->assertSame(1.6691306063588582, $number->value());
    }

    public function testSubtract()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->subtract(Number::of(66));

        $this->assertSame(-65.33086939364114, $number->value());
    }

    public function testDivideBy()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->divideBy(Number::of(2));

        $this->assertSame(0.3345653031794291, $number->value());
    }

    public function testMulitplyBy()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->multiplyBy(Number::of(2));

        $this->assertSame(1.3382612127177165, $number->value());
    }

    public function testRound()
    {
        $number = Sine::of(Degree::of(Number::of(42)))->number();

        $this->assertEquals(0.7, $number->roundUp(1)->value());
        $this->assertEquals(0.7, $number->roundDown(1)->value());
        $this->assertEquals(0.7, $number->roundEven(1)->value());
        $this->assertEquals(0.7, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->ceil();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->modulo(Number::of(3));

        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testAbsolute()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->absolute();

        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testPower()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->power(Number::of(2));

        $this->assertSame(0.4477357683661733, $number->value());
    }

    public function testSquareRoot()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->squareRoot();

        $this->assertSame(0.8180040381066943, $number->value());
    }

    public function testExponential()
    {
        $sin = Sine::of(Degree::of(Number::of(42)))->number();
        $number = $sin->exponential();

        $this->assertSame(1.9525390574726629, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Sine::of(Degree::of(Number::of(42)))
            ->number()
            ->binaryLogarithm();

        $this->assertSame(-0.5796402595724052, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Sine::of(Degree::of(Number::of(42)))
            ->number()
            ->naturalLogarithm();

        $this->assertSame(-0.4017760116616475, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Sine::of(Degree::of(Number::of(42)))
            ->number()
            ->commonLogarithm();

        $this->assertSame(-0.17448910482575006, $number->value());
    }

    public function testSignum()
    {
        $number = Sine::of(Degree::of(Number::of(42)))
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
