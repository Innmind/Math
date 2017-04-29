<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Number,
    NumberInterface,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Floor,
    Ceil,
    Modulo,
    Absolute,
    Power,
    SquareRoot
};
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            NumberInterface::class,
            new Number(42)
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\TypeError
     * @expectedExceptionMessage Number must be an int or a float
     */
    public function testThrowWhenValueNotAnIntNorAFloat()
    {
        new Number('42');
    }

    public function testInt()
    {
        $number = new Number(42);

        $this->assertSame(42, $number->value());
        $this->assertSame('42', (string) $number);
    }

    public function testFloat()
    {
        $number = new Number(42.24);

        $this->assertSame(42.24, $number->value());
        $this->assertSame('42.24', (string) $number);
    }

    public function testEquals()
    {
        $this->assertTrue((new Number(42))->equals(new Number(42)));
        $this->assertTrue((new Number(42))->equals(new Number(42.0)));
        $this->assertTrue((new Number(42.0))->equals(new Number(42)));
        $this->assertTrue(
            (new Number(42.1))->equals(new Number(
                42.099999999999999 # with a precision over 14 digits php will round it
            ))
        );
        $this->assertFalse((new Number(42))->equals(new Number(42.24)));
    }

    public function testHigherThan()
    {
        $this->assertFalse((new Number(42))->higherThan(new Number(42)));
        $this->assertTrue((new Number(42))->higherThan(new Number(41.24)));
    }

    public function testAdd()
    {
        $number = new Number(42);
        $number = $number->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(108, $number->value());
    }

    public function testSubtract()
    {
        $number = new Number(42);
        $number = $number->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24, $number->value());
    }

    public function testDivideBy()
    {
        $number = new Number(42);
        $number = $number->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = new Number(42);
        $number = $number->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84, $number->value());
    }

    public function testRound()
    {
        $number = new Number(42.25);
        $number = $number->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(42.3, $number->value());
    }

    public function testFloor()
    {
        $number = new Number(42.25);
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $number = new Number(42.25);
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $number = new Number(3);
        $number = $number->modulo(new Number(2));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $number = new Number(-9);
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(9, $number->value());
    }

    public function testPower()
    {
        $number = new Number(-9);
        $number = $number->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(81, $number->value());
    }

    public function testSquareRoot()
    {
        $number = new Number(4);
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }
}