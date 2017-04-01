<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra\Number;

use Innmind\Math\Algebra\{
    Number\Pi,
    NumberInterface,
    Number,
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

class PiTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(NumberInterface::class, new Pi);
    }

    public function testStringCast()
    {
        $this->assertSame('π', (string) new Pi);
    }

    public function testEquals()
    {
        $this->assertTrue((new Pi)->equals(new Number(3.141592653589793)));
        $this->assertFalse((new Pi)->equals(new Number(3.14)));
    }

    public function testHigherThan()
    {
        $this->assertTrue((new Pi)->higherThan(new Number(3.14)));
        $this->assertFalse((new Pi)->higherThan(new Number(3.15)));
    }

    public function testAdd()
    {
        $number = new Pi;
        $number = $number->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(69.1415926535898, $number->value());
    }

    public function testSubtract()
    {
        $number = new Pi;
        $number = $number->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-62.8584073464, $number->value());
    }

    public function testDivideBy()
    {
        $number = new Pi;
        $number = $number->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(M_PI_2, $number->value());
    }

    public function testMulitplyBy()
    {
        $number = new Pi;
        $number = $number->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(pi() * 2, $number->value());
    }

    public function testRound()
    {
        $number = new Pi;
        $number = $number->round(2);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(3.14, $number->value());
    }

    public function testFloor()
    {
        $number = new Pi;
        $number = $number->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(3.0, $number->value());
    }

    public function testCeil()
    {
        $number = new Pi;
        $number = $number->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(4.0, $number->value());
    }

    public function testModulo()
    {
        $number = new Pi;
        $number = $number->modulo(new Number(0.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.041592653589792944, $number->value());
    }

    public function testAbsolute()
    {
        $number = new Pi;
        $number = $number->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame((new Pi)->value(), $number->value());
    }

    public function testPower()
    {
        $number = new Pi;
        $number = $number->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(
            (new Pi)->multiplyBy(new Pi)->value(),
            $number->value()
        );
    }

    public function testSquareRoot()
    {
        $number = new Pi;
        $number = $number->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(M_SQRTPI, $number->value());
    }
}
