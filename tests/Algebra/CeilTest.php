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
    Round,
    Modulo,
    Absolute,
    Power,
    SquareRoot
};
use PHPUnit\Framework\TestCase;

class CeilTest extends TestCase
{
    public function testInterface()
    {
        $ceil = new Ceil(new Number(42.42));

        $this->assertInstanceOf(NumberInterface::class, $ceil);
    }

    /**
     * @dataProvider values
     */
    public function testValue($number, $expected)
    {
        $ceil = new Ceil(new Number($number));

        $this->assertSame($expected, $ceil->value());
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
        $ceil = new Ceil(new Number(42.45));

        $this->assertTrue($ceil->equals(new Number(43)));
        $this->assertTrue($ceil->equals(new Number(43.0)));
        $this->assertFalse($ceil->equals(new Number(42)));
    }

    public function testHigherThan()
    {
        $ceil = new Ceil(new Number(42.45));

        $this->assertTrue($ceil->higherThan(new Number(41.9)));
        $this->assertFalse($ceil->higherThan(new Number(43.5)));
    }

    public function testAdd()
    {
        $ceil = new Ceil(new Number(42.5));
        $number = $ceil->add(new Number(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $ceil = new Ceil(new Number(42.5));
        $number = $ceil->subtract(new Number(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $ceil = new Ceil(new Number(42.5));
        $number = $ceil->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $ceil = new Ceil(new Number(42.5));
        $number = $ceil->divideBy(new Number(2));

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
        $ceil = new Ceil(new Number(42.45));
        $number = $ceil->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testCeil()
    {
        $ceil = new Ceil(new Number(42.45));
        $number = $ceil->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $ceil = new Ceil(new Number(42.45));
        $number = $ceil->modulo(new Number(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $ceil = new Ceil(new Number(-42.45));
        $number = $ceil->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $ceil = new Ceil(new Number(2.5));
        $number = $ceil->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ceil = new Ceil(new Number(3.5));
        $number = $ceil->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
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
