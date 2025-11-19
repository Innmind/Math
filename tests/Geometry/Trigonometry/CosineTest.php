<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
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

class CosineTest extends TestCase
{
    public function testInterface()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));

        $this->assertInstanceOf(Number::class, $cos);
        $this->assertSame(0.7431448254773942, $cos->value());
        $this->assertSame('cos(42°)', $cos->toString());
    }

    public function testEquals()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));

        $this->assertTrue($cos->equals($cos));
        $this->assertTrue($cos->equals(Real::of(0.7431448254773942)));
        $this->assertFalse($cos->equals(Real::of(0.74)));
    }

    public function testHigherThan()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));

        $this->assertFalse($cos->higherThan($cos));
        $this->assertFalse($cos->higherThan(Real::of(0.7431448254773942)));
        $this->assertTrue($cos->higherThan(Real::of(0.74)));
    }

    public function testAdd()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->add(Real::of(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(1.7431448254773942, $number->value());
    }

    public function testSubtract()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-65.2568551745226, $number->value());
    }

    public function testDivideBy()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(0.3715724127386971, $number->value());
    }

    public function testMulitplyBy()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(1.4862896509547885, $number->value());
    }

    public function testRound()
    {
        $number = Cosine::of(Degree::of(Real::of(42)));

        $this->assertEquals(0.7, $number->roundUp(1)->value());
        $this->assertEquals(0.7, $number->roundDown(1)->value());
        $this->assertEquals(0.7, $number->roundEven(1)->value());
        $this->assertEquals(0.7, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->modulo(Real::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.7431448254773942, $number->value());
    }

    public function testAbsolute()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(0.7431448254773942, $number->value());
    }

    public function testPower()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(0.5522642316338268, $number->value());
    }

    public function testSquareRoot()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(0.8620584814717586, $number->value());
    }

    public function testExponential()
    {
        $cos = Cosine::of(Degree::of(Real::of(42)));
        $number = $cos->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(2.1025372410974477, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Cosine::of(Degree::of(Real::of(42)))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(-0.42828470156966353, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Cosine::of(Degree::of(Real::of(42)))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(-0.29686433336996987, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Cosine::of(Degree::of(Real::of(42)))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(-0.1289265418564653, $number->value());
    }

    public function testSignum()
    {
        $number = Cosine::of(Degree::of(Real::of(42)))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
