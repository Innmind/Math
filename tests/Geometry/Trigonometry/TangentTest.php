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
    Algebra\Signum
};
use PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));

        $this->assertInstanceOf(Number::class, $tan);
        $this->assertSame(0.90040404429784, $tan->value());
        $this->assertSame('tan(42°)', $tan->toString());
    }

    public function testEquals()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));

        $this->assertTrue($tan->equals($tan));
        $this->assertTrue($tan->equals(new Number\Number(0.9004040442978399)));
        $this->assertFalse($tan->equals(new Number\Number(0.9)));
    }

    public function testHigherThan()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));

        $this->assertFalse($tan->higherThan($tan));
        $this->assertFalse($tan->higherThan(new Number\Number(0.9004040442978399)));
        $this->assertTrue($tan->higherThan(new Number\Number(0.9)));
    }

    public function testAdd()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->add(new Number\Number(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(1.90040404429784, $number->value());
    }

    public function testSubtract()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.09959595570216, $number->value());
    }

    public function testDivideBy()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.45020202214891997, $number->value());
    }

    public function testMulitplyBy()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(1.8008080885956799, $number->value());
    }

    public function testRound()
    {
        $number = new Tangent(new Degree(new Number\Number(42)));

        $this->assertSame(0.9, $number->roundUp(1)->value());
        $this->assertSame(0.9, $number->roundDown(1)->value());
        $this->assertSame(0.9, $number->roundEven(1)->value());
        $this->assertSame(0.9, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->modulo(new Number\Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testAbsolute()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.9004040442978399, $number->value());
    }

    public function testPower()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.8107274429879064, $number->value());
    }

    public function testSquareRoot()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.9488962241983261, $number->value());
    }

    public function testExponential()
    {
        $tan = new Tangent(new Degree(new Number\Number(42)));
        $number = $tan->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(2.4605971005633154, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new Tangent(new Degree(new Number\Number(42))))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(-0.1513555580027417, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new Tangent(new Degree(new Number\Number(42))))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(-0.10491167829167766, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new Tangent(new Degree(new Number\Number(42))))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(-0.045562562969284785, $number->value());
    }

    public function testSignum()
    {
        $number = (new Tangent(new Degree(new Number\Number(42))))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
