<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Median,
    Algebra\NumberInterface,
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
    Algebra\SquareRoot
};
use PHPUnit\Framework\TestCase;

class MedianTest extends TestCase
{
    public function testEvenSetResult()
    {
        $median = new Median(
            new Number(1),
            new Number(2),
            new Number(2),
            new Number(2),
            new Number(3),
            new Number(5),
            new Number(5),
            new Number(6),
            new Number(6),
            new Number(7)
        );

        $this->assertInstanceOf(NumberInterface::class, $median->result());
        $this->assertSame($median->result(), $median->result());
        $this->assertSame(4, $median->result()->value());
    }

    public function testOddSetResult()
    {
        $median = new Median(
            new Number(1),
            new Number(2),
            new Number(2),
            new Number(2),
            new Number(3),
            $expected = new Number(5),
            new Number(5),
            new Number(6),
            new Number(6),
            new Number(7),
            new Number(8)
        );

        $this->assertInstanceOf(NumberInterface::class, $median->result());
        $this->assertSame($median->result(), $median->result());
        $this->assertSame($expected, $median->result());
        $this->assertSame(5, $median->result()->value());
    }

    public function testEquals()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );

        $this->assertTrue($median->equals(new Number(4)));
        $this->assertTrue($median->equals(new Number(4.0)));
        $this->assertFalse($median->equals(new Number(4.1)));
    }

    public function testHigherThan()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );

        $this->assertTrue($median->higherThan(new Number(3.9)));
        $this->assertFalse($median->higherThan(new Number(4)));
    }

    public function testAdd()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $median = new Median(
            new Number(1),
            new Number(7.12)
        );
        $number = $median->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(4.1, $number->value());
    }

    public function testFloor()
    {
        $median = new Median(
            new Number(1),
            new Number(7.1)
        );
        $number = $median->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $median = new Median(
            new Number(1),
            new Number(7.1)
        );
        $number = $median->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->modulo(new Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $median = new Median(
            new Number(-1),
            new Number(-7)
        );
        $number = $median->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(4, $number->value());
    }

    public function testPower()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(16, $number->value());
    }

    public function testSquareRoot()
    {
        $median = new Median(
            new Number(1),
            new Number(7)
        );
        $number = $median->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testStringCast()
    {
        $median = new Median(
            new Number(1),
            new Number(7.1)
        );

        $this->assertSame('(1 + 7.1) ÷ 2', (string) $median);
    }
}
