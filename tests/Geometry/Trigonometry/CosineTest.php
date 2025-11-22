<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CosineTest extends TestCase
{
    public function testInterface()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)));

        $this->assertSame(0.7431448254773942, $cos->number()->value());
        $this->assertSame('cos(42°)', $cos->toString());
    }

    public function testEquals()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();

        $this->assertTrue($cos->equals($cos));
        $this->assertTrue($cos->equals(Number::of(0.7431448254773942)));
        $this->assertFalse($cos->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();

        $this->assertFalse($cos->higherThan($cos));
        $this->assertFalse($cos->higherThan(Number::of(0.7431448254773942)));
        $this->assertTrue($cos->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->add(Number::of(1));

        $this->assertSame(1.7431448254773942, $number->value());
    }

    public function testSubtract()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->subtract(Number::of(66));

        $this->assertSame(-65.2568551745226, $number->value());
    }

    public function testDivideBy()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->divideBy(Number::of(2));

        $this->assertSame(0.3715724127386971, $number->value());
    }

    public function testMulitplyBy()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->multiplyBy(Number::of(2));

        $this->assertSame(1.4862896509547885, $number->value());
    }

    public function testRound()
    {
        $number = Cosine::of(Degree::of(Number::of(42)))->number();

        $this->assertEquals(0.7, $number->roundUp(1)->value());
        $this->assertEquals(0.7, $number->roundDown(1)->value());
        $this->assertEquals(0.7, $number->roundEven(1)->value());
        $this->assertEquals(0.7, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->ceil();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->modulo(Number::of(3));

        $this->assertSame(0.7431448254773942, $number->value());
    }

    public function testAbsolute()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->absolute();

        $this->assertSame(0.7431448254773942, $number->value());
    }

    public function testPower()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->power(Number::of(2));

        $this->assertSame(0.5522642316338268, $number->value());
    }

    public function testSquareRoot()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->squareRoot();

        $this->assertSame(0.8620584814717586, $number->value());
    }

    public function testExponential()
    {
        $cos = Cosine::of(Degree::of(Number::of(42)))->number();
        $number = $cos->exponential();

        $this->assertSame(2.1025372410974477, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Cosine::of(Degree::of(Number::of(42)))
            ->number()
            ->binaryLogarithm();

        $this->assertSame(-0.42828470156966353, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Cosine::of(Degree::of(Number::of(42)))
            ->number()
            ->naturalLogarithm();

        $this->assertSame(-0.29686433336996987, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Cosine::of(Degree::of(Number::of(42)))
            ->number()
            ->commonLogarithm();

        $this->assertSame(-0.1289265418564653, $number->value());
    }

    public function testSignum()
    {
        $number = Cosine::of(Degree::of(Number::of(42)))
            ->number()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
