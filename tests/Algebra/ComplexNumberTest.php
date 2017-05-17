<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use function Innmind\Math\add;
use Innmind\Math\Algebra\{
    ComplexNumber,
    Integer,
    NumberInterface
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

    public function testConjugate()
    {
        $number = new ComplexNumber(
            new Integer(2),
            new Integer(3)
        );
        $conjugate = $number->conjugate();

        $this->assertInstanceOf(ComplexNumber::class, $conjugate);
        $this->assertNotSame($number, $conjugate);
        $this->assertSame('(2 + 3i)', (string) $number);
        $this->assertSame('(2 + (-1 x 3)i)', (string) $conjugate);
    }

    public function testAbsolute()
    {
        $number = new ComplexNumber(
            new Integer(2),
            new Integer(3)
        );
        $absolute = $number->absolute();

        $this->assertInstanceOf(NumberInterface::class, $absolute);
        $this->assertSame(sqrt(13), $absolute->value());
    }

    public function testReciprocal()
    {
        $number = new ComplexNumber(
            new Integer(2),
            new Integer(3)
        );
        $reciprocal = $number->reciprocal();

        $this->assertInstanceOf(ComplexNumber::class, $reciprocal);
        $this->assertNotSame($number, $reciprocal);
        $this->assertSame('(2 + 3i)', (string) $number);
        $this->assertSame(
            '((2 ÷ ((2^2) + (3^2))) + (-1 x (3 ÷ ((2^2) + (3^2))))i)',
            (string) $reciprocal
        );
    }

    public function testEquals()
    {
        $number = new ComplexNumber(
            new Integer(2),
            new Integer(3)
        );

        $this->assertTrue($number->equals($number));
        $this->assertTrue($number->equals(
            new ComplexNumber(
                new Integer(2),
                new Integer(3)
            )
        ));
        $this->assertFalse($number->equals(
            new ComplexNumber(
                new Integer(3),
                new Integer(3)
            )
        ));
    }
}
