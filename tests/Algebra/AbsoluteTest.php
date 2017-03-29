<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Absolute,
    Ceil,
    Floor,
    NumberInterface,
    OperationInterface,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Modulo
};
use PHPUnit\Framework\TestCase;

class AbsoluteTest extends TestCase
{
    public function testInterface()
    {
        $absolute = new Absolute(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $absolute);
        $this->assertInstanceOf(OperationInterface::class, $absolute);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $absolute = new Absolute(new Number($number));

        $this->assertSame($expected, $absolute->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '|42.45|',
            (string) new Absolute(new Number(42.45))
        );
    }

    public function testEquals()
    {
        $absolute = new Absolute(new Number(-42.45));

        $this->assertTrue($absolute->equals(new Number(42.45)));
        $this->assertFalse($absolute->equals(new Number(-42.45)));
    }

    public function testHigherThan()
    {
        $absolute = new Absolute(new Number(-42.45));

        $this->assertTrue($absolute->higherThan(new Number(0)));
        $this->assertFalse($absolute->higherThan(new Number(43)));
    }

    public function testAdd()
    {
        $absolute = new Absolute(new Number(-43));
        $number = $absolute->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50, $number->value());
    }

    public function testSubtract()
    {
        $absolute = new Absolute(new Number(-43));
        $number = $absolute->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testMultiplication()
    {
        $absolute = new Absolute(new Number(-43));
        $number = $absolute->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86, $number->value());
    }

    public function testDivision()
    {
        $absolute = new Absolute(new Number(-43));
        $number = $absolute->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $round = new Absolute(new Number(-42.45));
        $number = $round->round();

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testFloor()
    {
        $absolute = new Absolute(new Number(-42.45));
        $number = $absolute->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $absolute = new Absolute(new Number(-42.45));
        $number = $absolute->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testAbsolute()
    {
        $absolute = new Absolute(new Number(-42.45));
        $number = $absolute->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.45, $number->value());
    }

    public function testModulo()
    {
        $absolute = new Absolute(new Number(-42.45));
        $number = $absolute->modulo(new Number(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.45, $number->value());
    }

    public function values(): array
    {
        return [
            [-1, 1],
            [1, 1],
        ];
    }
}
