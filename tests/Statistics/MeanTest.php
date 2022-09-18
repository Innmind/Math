<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Mean,
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

class MeanTest extends TestCase
{
    public function testResult()
    {
        $mean = Mean::of(
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

        $this->assertInstanceOf(Number::class, $mean->result());
        $this->assertSame($mean->result(), $mean->result());
        $this->assertSame(3.9, $mean->result()->value());
    }

    public function testEquals()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );

        $this->assertTrue($mean->equals(Number\Number::of(4)));
        $this->assertTrue($mean->equals(Number\Number::of(4.0)));
        $this->assertFalse($mean->equals(Number\Number::of(4.1)));
    }

    public function testHigherThan()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );

        $this->assertTrue($mean->higherThan(Number\Number::of(3.9)));
        $this->assertFalse($mean->higherThan(Number\Number::of(4)));
    }

    public function testAdd()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->add(Number\Number::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->subtract(Number\Number::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->divideBy(Number\Number::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->multiplyBy(Number\Number::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $number = Mean::of(
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
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7.1),
        );
        $number = $mean->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7.1),
        );
        $number = $mean->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->modulo(Number\Number::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $mean = Mean::of(
            Number\Number::of(-1),
            Number\Number::of(-7),
        );
        $number = $mean->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(4, $number->value());
    }

    public function testPower()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->power(Number\Number::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        );
        $number = $mean->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $mean = Mean::of(
            Number\Number::of(1),
            Number\Number::of(7.1),
        );

        $this->assertSame('(1 + 7.1) ÷ 2', $mean->toString());
    }
}
