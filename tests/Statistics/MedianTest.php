<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Median,
    Algebra\Number,
    Algebra\Logarithm,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MedianTest extends TestCase
{
    public function testEvenSetResult()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(2),
            Number::of(2),
            Number::of(2),
            Number::of(3),
            Number::of(5),
            Number::of(5),
            Number::of(6),
            Number::of(6),
            Number::of(7),
        );

        $this->assertInstanceOf(Number::class, $median->result());
        $this->assertSame($median->result(), $median->result());
        $this->assertSame(4, $median->result()->value());
    }

    public function testOddSetResult()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(2),
            Number::of(2),
            Number::of(2),
            Number::of(3),
            $expected = Number::of(5),
            Number::of(5),
            Number::of(6),
            Number::of(6),
            Number::of(7),
            Number::of(8),
        );

        $this->assertInstanceOf(Number::class, $median->result());
        $this->assertSame($median->result(), $median->result());
        $this->assertSame($expected, $median->result());
        $this->assertSame(5, $median->result()->value());
    }

    public function testEquals()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();

        $this->assertTrue($median->equals(Number::of(4)));
        $this->assertTrue($median->equals(Number::of(4.0)));
        $this->assertFalse($median->equals(Number::of(4.1)));
    }

    public function testHigherThan()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();

        $this->assertTrue($median->higherThan(Number::of(3.9)));
        $this->assertFalse($median->higherThan(Number::of(4)));
    }

    public function testAdd()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->add(Number::of(66));

        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->subtract(Number::of(66));

        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->divideBy(Number::of(2));

        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->multiplyBy(Number::of(2));

        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = Median::of(
            Number::of(1),
            Number::of(7.12),
        )->result();

        $this->assertEquals(4.1, $number->roundUp(1)->value());
        $this->assertEquals(4.1, $number->roundDown(1)->value());
        $this->assertEquals(4.1, $number->roundEven(1)->value());
        $this->assertEquals(4.1, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7.1),
        )->result();
        $number = $median->floor();

        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7.1),
        )->result();
        $number = $median->ceil();

        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->modulo(Number::of(3));

        $this->assertSame(1, $number->value());
    }

    public function testAbsolute()
    {
        $median = Median::of(
            Number::of(-1),
            Number::of(-7),
        )->result();
        $number = $median->absolute();

        $this->assertSame(4, $number->value());
    }

    public function testPower()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->power(Number::of(2));

        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $median->squareRoot();

        $this->assertSame(2, $number->value());
    }

    public function testExponential()
    {
        $mean = Median::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Median::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->apply(Logarithm::binary);

        $this->assertSame(2, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Median::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->apply(Logarithm::natural);

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Median::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->apply(Logarithm::common);

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Median::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->signum();

        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $median = Median::of(
            Number::of(1),
            Number::of(7.1),
        )->result();

        $this->assertSame('(1 + 7.1) ÷ 2', $median->toString());
    }
}
