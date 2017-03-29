<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Mean,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
    Algebra\Floor,
    Algebra\Ceil,
    Algebra\Modulo
};
use PHPUnit\Framework\TestCase;

class MeanTest extends TestCase
{
    public function testResult()
    {
        $mean = new Mean(
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

        $this->assertInstanceOf(NumberInterface::class, $mean->result());
        $this->assertSame($mean->result(), $mean->result());
        $this->assertSame(3.9, $mean->result()->value());
    }

    public function testEquals()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );

        $this->assertTrue($mean->equals(new Number(4)));
        $this->assertTrue($mean->equals(new Number(4.0)));
        $this->assertFalse($mean->equals(new Number(4.1)));
    }

    public function testHigherThan()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );

        $this->assertTrue($mean->higherThan(new Number(3.9)));
        $this->assertFalse($mean->higherThan(new Number(4)));
    }

    public function testAdd()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );
        $number = $mean->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(70, $number->value());
    }

    public function testSubtract()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );
        $number = $mean->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62, $number->value());
    }

    public function testDivideBy()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );
        $number = $mean->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(2, $number->value());
    }

    public function testMulitplyBy()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );
        $number = $mean->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(8, $number->value());
    }

    public function testRound()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7.12)
        );
        $number = $mean->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(4.1, $number->value());
    }

    public function testFloor()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7.1)
        );
        $number = $mean->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testCeil()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7.1)
        );
        $number = $mean->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(5.0, $number->value());
    }

    public function testModulo()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7)
        );
        $number = $mean->modulo(new Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testStringCast()
    {
        $mean = new Mean(
            new Number(1),
            new Number(7.1)
        );

        $this->assertSame('(1 + 7.1) ÷ 2', (string) $mean);
    }
}
