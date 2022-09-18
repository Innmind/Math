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
        $sin = Sine::of(Degree::of(Number\Number::of(42)));

        $this->assertInstanceOf(Number::class, $sin);
        $this->assertSame(0.6691306063588582, $sin->value());
        $this->assertSame('sin(42°)', $sin->toString());
    }

    public function testEquals()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));

        $this->assertTrue($sin->equals($sin));
        $this->assertTrue($sin->equals(Number\Number::of(0.6691306063588582)));
        $this->assertFalse($sin->equals(Number\Number::of(0.66)));
    }

    public function testHigherThan()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));

        $this->assertFalse($sin->higherThan($sin));
        $this->assertFalse($sin->higherThan(Number\Number::of(0.6691306063588582)));
        $this->assertTrue($sin->higherThan(Number\Number::of(0.66)));
    }

    public function testAdd()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->add(Number\Number::of(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(1.6691306063588582, $number->value());
    }

    public function testSubtract()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.33086939364114, $number->value());
    }

    public function testDivideBy()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.3345653031794291, $number->value());
    }

    public function testMulitplyBy()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(1.3382612127177165, $number->value());
    }

    public function testRound()
    {
        $number = Sine::of(Degree::of(Number\Number::of(42)));

        $this->assertEquals(0.7, $number->roundUp(1)->value());
        $this->assertEquals(0.7, $number->roundDown(1)->value());
        $this->assertEquals(0.7, $number->roundEven(1)->value());
        $this->assertEquals(0.7, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->modulo(Number\Number::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testAbsolute()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.6691306063588582, $number->value());
    }

    public function testPower()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.4477357683661733, $number->value());
    }

    public function testSquareRoot()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.8180040381066943, $number->value());
    }

    public function testExponential()
    {
        $sin = Sine::of(Degree::of(Number\Number::of(42)));
        $number = $sin->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.9525390574726629, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Sine::of(Degree::of(Number\Number::of(42)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(-0.5796402595724052, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Sine::of(Degree::of(Number\Number::of(42)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(-0.4017760116616475, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Sine::of(Degree::of(Number\Number::of(42)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(-0.17448910482575006, $number->value());
    }

    public function testSignum()
    {
        $number = Sine::of(Degree::of(Number\Number::of(42)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
