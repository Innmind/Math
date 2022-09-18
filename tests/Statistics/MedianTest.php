<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Median,
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

class MedianTest extends TestCase
{
    public function testEvenSetResult()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(2),
            Number\Number::of(2),
            Number\Number::of(2),
            Number\Number::of(3),
            Number\Number::of(5),
            Number\Number::of(5),
            Number\Number::of(6),
            Number\Number::of(6),
            Number\Number::of(7),
        );

        $this->assertInstanceOf(Number::class, $median->result());
        $this->assertSame($median->result(), $median->result());
        $this->assertSame(4, $median->result()->value());
    }

    public function testOddSetResult()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(2),
            Number\Number::of(2),
            Number\Number::of(2),
            Number\Number::of(3),
            $expected = Number\Number::of(5),
            Number\Number::of(5),
            Number\Number::of(6),
            Number\Number::of(6),
            Number\Number::of(7),
            Number\Number::of(8),
        );

        $this->assertInstanceOf(Number::class, $median->result());
        $this->assertSame($median->result(), $median->result());
        $this->assertSame($expected, $median->result());
        $this->assertSame(5, $median->result()->value());
    }

    public function testEquals()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );

        $this->assertTrue($median->equals(Number\Number::of(4)));
        $this->assertTrue($median->equals(Number\Number::of(4.0)));
        $this->assertFalse($median->equals(Number\Number::of(4.1)));
    }

    public function testHigherThan()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );

        $this->assertTrue($median->higherThan(Number\Number::of(3.9)));
        $this->assertFalse($median->higherThan(Number\Number::of(4)));
    }

    public function testAdd()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = Median::of(
            Number\Number::of(1),
            Number\Number::of(7.12),
        );

        $this->assertEquals(4.1, $number->roundUp(1)->value());
        $this->assertEquals(4.1, $number->roundDown(1)->value());
        $this->assertEquals(4.1, $number->roundEven(1)->value());
        $this->assertEquals(4.1, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7.1),
        );
        $number = $median->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7.1),
        );
        $number = $median->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->modulo(Number\Number::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $median = Median::of(
            Number\Number::of(-1),
            Number\Number::of(-7),
        );
        $number = $median->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(4, $number->value());
    }

    public function testPower()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $median->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $mean = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Median::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $median = Median::of(
            Number\Number::of(1),
            Number\Number::of(7.1),
        );

        $this->assertSame('(1 + 7.1) ÷ 2', $median->toString());
    }
}
