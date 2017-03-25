<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Floor,
    NumberInterface,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division
};
use PHPUnit\Framework\TestCase;

class FloorTest extends TestCase
{
    public function testInterface()
    {
        $floor = new Floor(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $floor);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $floor = new Floor(new Number($number));

        $this->assertSame($expected, $floor->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '42',
            (string) new Floor(new Number(42.45))
        );
    }

    public function testEquals()
    {
        $floor = new Floor(new Number(42.45));

        $this->assertTrue($floor->equals(new Number(42.0)));
        $this->assertFalse($floor->equals(new Number(43)));
    }

    public function testHigherThan()
    {
        $floor = new Floor(new Number(42.45));

        $this->assertTrue($floor->higherThan(new Number(41.9)));
        $this->assertFalse($floor->higherThan(new Number(42.5)));
    }

    public function testAdd()
    {
        $floor = new Floor(new Number(42.5));
        $number = $floor->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(49.0, $number->value());
    }

    public function testSubtract()
    {
        $floor = new Floor(new Number(42.5));
        $number = $floor->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(35.0, $number->value());
    }

    public function testMultiplication()
    {
        $floor = new Floor(new Number(42.5));
        $number = $floor->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testDivision()
    {
        $floor = new Floor(new Number(42.5));
        $number = $floor->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testFloor()
    {
        $floor = new Floor(new Number(42.45));
        $number = $floor->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function values(): array
    {
        return [
            [42.4, 42.0],
            [42.5, 42.0],
            [42.6, 42.0],
            [42.51, 42.0],
        ];
    }
}
