<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Mean,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MeanTest extends TestCase
{
    public function testResult()
    {
        $mean = Mean::of(
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

        $this->assertInstanceOf(Number::class, $mean->result());
        $this->assertSame($mean->result(), $mean->result());
        $this->assertSame(3.9, $mean->result()->value());
    }

    public function testEquals()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();

        $this->assertTrue($mean->equals(Number::of(4)));
        $this->assertTrue($mean->equals(Number::of(4.0)));
        $this->assertFalse($mean->equals(Number::of(4.1)));
    }

    public function testHigherThan()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();

        $this->assertTrue($mean->higherThan(Number::of(3.9)));
        $this->assertFalse($mean->higherThan(Number::of(4)));
    }

    public function testAdd()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->add(Number::of(66));

        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->subtract(Number::of(66));

        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->divideBy(Number::of(2));

        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->multiplyBy(Number::of(2));

        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = Mean::of(
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
        $mean = Mean::of(
            Number::of(1),
            Number::of(7.1),
        )->result();
        $number = $mean->floor();

        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7.1),
        )->result();
        $number = $mean->ceil();

        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->modulo(Number::of(3));

        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $mean = Mean::of(
            Number::of(-1),
            Number::of(-7),
        )->result();
        $number = $mean->absolute();

        $this->assertSame(4, $number->value());
    }

    public function testPower()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->power(Number::of(2));

        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $mean->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Mean::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->binaryLogarithm();

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Mean::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->naturalLogarithm();

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Mean::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->commonLogarithm();

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Mean::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->signum();

        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $mean = Mean::of(
            Number::of(1),
            Number::of(7.1),
        )->result();

        $this->assertSame('(1 + 7.1) ÷ 2', $mean->toString());
    }
}
