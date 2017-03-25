<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Ceil,
    Floor,
    NumberInterface,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round
};
use PHPUnit\Framework\TestCase;

class CeilTest extends TestCase
{
    public function testInterface()
    {
        $floor = new Ceil(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $floor);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $floor = new Ceil(new Number($number));

        $this->assertSame($expected, $floor->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '43',
            (string) new Ceil(new Number(42.45))
        );
    }

    public function testEquals()
    {
        $floor = new Ceil(new Number(42.45));

        $this->assertTrue($floor->equals(new Number(43)));
        $this->assertTrue($floor->equals(new Number(43.0)));
        $this->assertFalse($floor->equals(new Number(42)));
    }

    public function testHigherThan()
    {
        $floor = new Ceil(new Number(42.45));

        $this->assertTrue($floor->higherThan(new Number(41.9)));
        $this->assertFalse($floor->higherThan(new Number(43.5)));
    }

    public function testAdd()
    {
        $floor = new Ceil(new Number(42.5));
        $number = $floor->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $floor = new Ceil(new Number(42.5));
        $number = $floor->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $floor = new Ceil(new Number(42.5));
        $number = $floor->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $floor = new Ceil(new Number(42.5));
        $number = $floor->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $round = new Ceil(new Number(42.45));
        $number = $round->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testFloor()
    {
        $floor = new Ceil(new Number(42.45));
        $number = $floor->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testCeil()
    {
        $floor = new Ceil(new Number(42.45));
        $number = $floor->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function values(): array
    {
        return [
            [42.4, 43.0],
            [42.5, 43.0],
            [42.6, 43.0],
            [42.51, 43.0],
        ];
    }
}
