<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Tangent,
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
    Algebra\Signum,
    Algebra\Real,
};
use PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));

        $this->assertInstanceOf(Number::class, $tan);
        $this->assertSame(0.90040404429784, $tan->value());
        $this->assertSame('tan(42°)', $tan->toString());
    }

    public function testEquals()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));

        $this->assertTrue($tan->equals($tan));
        $this->assertTrue($tan->equals(Real::of(0.9004040442978399)));
        $this->assertFalse($tan->equals(Real::of(0.9)));
    }

    public function testHigherThan()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));

        $this->assertFalse($tan->higherThan($tan));
        $this->assertFalse($tan->higherThan(Real::of(0.9004040442978399)));
        $this->assertTrue($tan->higherThan(Real::of(0.9)));
    }

    public function testAdd()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->add(Real::of(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(1.90040404429784, $number->value());
    }

    public function testSubtract()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.09959595570216, $number->value());
    }

    public function testDivideBy()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.45020202214891997, $number->value());
    }

    public function testMulitplyBy()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(1.8008080885956799, $number->value());
    }

    public function testRound()
    {
        $number = Tangent::of(Degree::of(Real::of(42)));

        $this->assertEquals(0.9, $number->roundUp(1)->value());
        $this->assertEquals(0.9, $number->roundDown(1)->value());
        $this->assertEquals(0.9, $number->roundEven(1)->value());
        $this->assertEquals(0.9, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->modulo(Real::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testAbsolute()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testPower()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.8107274429879064, $number->value());
    }

    public function testSquareRoot()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.9488962241983261, $number->value());
    }

    public function testExponential()
    {
        $tan = Tangent::of(Degree::of(Real::of(42)));
        $number = $tan->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(2.4605971005633154, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Tangent::of(Degree::of(Real::of(42)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(-0.1513555580027417, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Tangent::of(Degree::of(Real::of(42)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(-0.10491167829167766, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Tangent::of(Degree::of(Real::of(42)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(-0.045562562969284785, $number->value());
    }

    public function testSignum()
    {
        $number = Tangent::of(Degree::of(Real::of(42)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
