<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
    Algebra\Floor,
    Algebra\Ceil,
    Algebra\Modulo,
    Algebra\Absolute,
    Algebra\Power,
    Algebra\SquareRoot,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum
};
use PHPUnit\Framework\TestCase;

class SineTest extends TestCase
{
    public function testInterface()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));

        $this->assertInstanceOf(Number::class, $sin);
        $this->assertSame(0.66913060635886, $sin->value());
        $this->assertSame('sin(42°)', (string) $sin);
    }

    public function testEquals()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));

        $this->assertTrue($sin->equals($sin));
        $this->assertTrue($sin->equals(new Number\Number(0.6691306063588582)));
        $this->assertFalse($sin->equals(new Number\Number(0.66)));
    }

    public function testHigherThan()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));

        $this->assertFalse($sin->higherThan($sin));
        $this->assertFalse($sin->higherThan(new Number\Number(0.6691306063588582)));
        $this->assertTrue($sin->higherThan(new Number\Number(0.66)));
    }

    public function testAdd()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->add(new Number\Number(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(1.6691306063588582, $number->value());
    }

    public function testSubtract()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.33086939364114, $number->value());
    }

    public function testDivideBy()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.3345653031794291, $number->value());
    }

    public function testMulitplyBy()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(1.3382612127177165, $number->value());
    }

    public function testRound()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(0.7, $number->value());
    }

    public function testFloor()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->modulo(new Number\Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testAbsolute()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testPower()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.4477357683661733, $number->value());
    }

    public function testSquareRoot()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.8180040381066943, $number->value());
    }

    public function testExponential()
    {
        $sin = new Sine(new Degree(new Number\Number(42)));
        $number = $sin->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.9525390574726629, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Sine(new Degree(new Number\Number(42))))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(-0.5796402595724052, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Sine(new Degree(new Number\Number(42))))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(-0.4017760116616475, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Sine(new Degree(new Number\Number(42))))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(-0.17448910482575006, $number->value());
    }

    public function testSignum()
    {
        $number = (new Sine(new Degree(new Number\Number(42))))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
