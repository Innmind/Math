<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use function Innmind\Math\add;
use Innmind\Math\Algebra\{
    ComplexNumber,
    Integer
};
use PHPUnit\Framework\TestCase;

class ComplexNumberTest extends TestCase
{
    public function testInterface()
    {
        $number = new ComplexNumber(
            $real = new Integer(1),
            $imaginary = new Integer(2)
        );

        $this->assertSame($real, $number->real());
        $this->assertSame($imaginary, $number->imaginary());
    }

    public function testStringCast()
    {
        $number = new ComplexNumber(
            new Integer(1),
            new Integer(2)
        );

        $this->assertSame('(1 + 2i)', (string) $number);

        $number = new ComplexNumber(
            add(1, 2),
            add(2, 3)
        );

        $this->assertSame('((1 + 2) + (2 + 3)i)', (string) $number);
    }

    public function testAdd()
    {
        $number = (new ComplexNumber(
            new Integer(2),
            new Integer(3)
        ))->add(new ComplexNumber(
            new Integer(4),
            new Integer(5)
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(6, $number->real()->value());
        $this->assertSame(8, $number->imaginary()->value());
    }

    public function testSubtract()
    {
        $number = (new ComplexNumber(
            new Integer(2),
            new Integer(3)
        ))->subtract(new ComplexNumber(
            new Integer(4),
            new Integer(5)
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(-2, $number->real()->value());
        $this->assertSame(-2, $number->imaginary()->value());
    }

    public function testMultiplyBy()
    {
        $number = (new ComplexNumber(
            new Integer(2),
            new Integer(3)
        ))->multiplyBy(new ComplexNumber(
            new Integer(4),
            new Integer(5)
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(-7, $number->real()->value());
        $this->assertSame(22, $number->imaginary()->value());
    }

    public function testDivideBy()
    {
        $number = (new ComplexNumber(
            new Integer(2),
            new Integer(3)
        ))->divideBy(new ComplexNumber(
            new Integer(4),
            new Integer(5)
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(23/41, $number->real()->value());
        $this->assertSame(2/41, $number->imaginary()->value());
    }
}
