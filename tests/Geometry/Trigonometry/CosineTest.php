<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CosineTest extends TestCase
{
    public function testInterface()
    {
        $cos = Degree::of(Number::of(42))->cosine();

        $this->assertSame(0.7431448254773942, $cos->value());
        $this->assertSame('cos(42°)', $cos->toString());
    }

    public function testEquals()
    {
        $cos = Degree::of(Number::of(42))->cosine();

        $this->assertTrue($cos->equals($cos));
        $this->assertTrue($cos->equals(Number::of(0.7431448254773942)));
        $this->assertFalse($cos->equals(Number::of(0.74)));
    }

    public function testHigherThan()
    {
        $cos = Degree::of(Number::of(42))->cosine();

        $this->assertFalse($cos->higherThan($cos));
        $this->assertFalse($cos->higherThan(Number::of(0.7431448254773942)));
        $this->assertTrue($cos->higherThan(Number::of(0.74)));
    }

    public function testAdd()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->add(Number::of(1));

        $this->assertSame(1.7431448254773942, $number->value());
    }

    public function testSubtract()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->subtract(Number::of(66));

        $this->assertSame(-65.2568551745226, $number->value());
    }

    public function testDivideBy()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->divideBy(Number::of(2));

        $this->assertSame(0.3715724127386971, $number->value());
    }

    public function testMulitplyBy()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->multiplyBy(Number::of(2));

        $this->assertSame(1.4862896509547885, $number->value());
    }

    public function testRound()
    {
        $number = Degree::of(Number::of(42))->cosine();

        $this->assertEquals(0.7, $number->roundUp(1)->value());
        $this->assertEquals(0.7, $number->roundDown(1)->value());
        $this->assertEquals(0.7, $number->roundEven(1)->value());
        $this->assertEquals(0.7, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->floor();

        $this->assertSame(0.0, $number->value());
    }

    public function testCeil()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->ceil();

        $this->assertSame(1.0, $number->value());
    }

    public function testModulo()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->modulo(Number::of(3));

        $this->assertSame(0.7431448254773942, $number->value());
    }

    public function testAbsolute()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->absolute();

        $this->assertSame(0.7431448254773942, $number->value());
    }

    public function testPower()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->power(Number::of(2));

        $this->assertSame(0.5522642316338268, $number->value());
    }

    public function testSquareRoot()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->squareRoot();

        $this->assertSame(0.8620584814717586, $number->value());
    }

    public function testExponential()
    {
        $cos = Degree::of(Number::of(42))->cosine();
        $number = $cos->exponential();

        $this->assertSame(2.1025372410974477, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->cosine()
            ->binaryLogarithm();

        $this->assertSame(-0.42828470156966353, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->cosine()
            ->naturalLogarithm();

        $this->assertSame(-0.29686433336996987, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Degree::of(Number::of(42))
            ->cosine()
            ->commonLogarithm();

        $this->assertSame(-0.1289265418564653, $number->value());
    }

    public function testSignum()
    {
        $number = Degree::of(Number::of(42))
            ->cosine()
            ->signum();

        $this->assertSame(1, $number->value());
    }
}
