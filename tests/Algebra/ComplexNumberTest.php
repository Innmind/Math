<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    ComplexNumber,
    Integer,
    Number,
    Value,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ComplexNumberTest extends TestCase
{
    public function testInterface()
    {
        $number = ComplexNumber::of(
            $real = Integer::of(1),
            $imaginary = Integer::of(2),
        );

        $this->assertSame($real, $number->real());
        $this->assertSame($imaginary, $number->imaginary());
    }

    public function testStringCast()
    {
        $number = ComplexNumber::of(
            Integer::of(1),
            Integer::of(2),
        );

        $this->assertSame('(1 + 2i)', $number->toString());

        $number = ComplexNumber::of(
            Value::one->add(Value::two),
            Value::two->add(Integer::of(3)),
        );

        $this->assertSame('((1 + 2) + (2 + 3)i)', $number->toString());
    }

    public function testAdd()
    {
        $number = (ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        ))->add(ComplexNumber::of(
            Integer::of(4),
            Integer::of(5),
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(6, $number->real()->value());
        $this->assertSame(8, $number->imaginary()->value());
    }

    public function testSubtract()
    {
        $number = (ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        ))->subtract(ComplexNumber::of(
            Integer::of(4),
            Integer::of(5),
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(-2, $number->real()->value());
        $this->assertSame(-2, $number->imaginary()->value());
    }

    public function testMultiplyBy()
    {
        $number = (ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        ))->multiplyBy(ComplexNumber::of(
            Integer::of(4),
            Integer::of(5),
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(-7, $number->real()->value());
        $this->assertSame(22, $number->imaginary()->value());
    }

    public function testDivideBy()
    {
        $number = (ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        ))->divideBy(ComplexNumber::of(
            Integer::of(4),
            Integer::of(5),
        ));

        $this->assertInstanceOf(ComplexNumber::class, $number);
        $this->assertSame(23/41, $number->real()->value());
        $this->assertSame(2/41, $number->imaginary()->value());
    }

    public function testConjugate()
    {
        $number = ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        );
        $conjugate = $number->conjugate();

        $this->assertInstanceOf(ComplexNumber::class, $conjugate);
        $this->assertNotSame($number, $conjugate);
        $this->assertSame('(2 + 3i)', $number->toString());
        $this->assertSame('(2 + (-1 x 3)i)', $conjugate->toString());
    }

    public function testAbsolute()
    {
        $number = ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        );
        $absolute = $number->absolute();

        $this->assertInstanceOf(Number::class, $absolute);
        $this->assertSame(\sqrt(13), $absolute->value());
    }

    public function testReciprocal()
    {
        $number = ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        );
        $reciprocal = $number->reciprocal();

        $this->assertInstanceOf(ComplexNumber::class, $reciprocal);
        $this->assertNotSame($number, $reciprocal);
        $this->assertSame('(2 + 3i)', $number->toString());
        $this->assertSame(
            '((2 ÷ ((2^2) + (3^2))) + (-1 x (3 ÷ ((2^2) + (3^2))))i)',
            $reciprocal->toString(),
        );
    }

    public function testNegate()
    {
        $number = ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        );
        $negation = $number->negation();

        $this->assertInstanceOf(ComplexNumber::class, $negation);
        $this->assertNotSame($number, $negation);
        $this->assertSame('(2 + 3i)', $number->toString());
        $this->assertSame('((-1 x 2) + (-1 x 3)i)', $negation->toString());
    }

    public function testSquareRoot()
    {
        $number = ComplexNumber::of(
            Integer::of(3),
            Integer::of(4),
        );
        $squareRoot = $number->squareRoot();

        $this->assertInstanceOf(ComplexNumber::class, $squareRoot);
        $this->assertNotSame($number, $squareRoot);
        $this->assertSame('(3 + 4i)', $number->toString());
        $this->assertSame(2.0, $squareRoot->real()->value());
        $this->assertSame(1.0, $squareRoot->imaginary()->value());
        $this->assertSame(
            '((√((3 + (√((3^2) + (4^2)))) ÷ 2)) + (sgn(4) x (√(((-1 x 3) + (√((3^2) + (4^2)))) ÷ 2)))i)',
            $squareRoot->toString(),
        );
    }

    public function testEquals()
    {
        $number = ComplexNumber::of(
            Integer::of(2),
            Integer::of(3),
        );

        $this->assertTrue($number->equals($number));
        $this->assertTrue($number->equals(
            ComplexNumber::of(
                Integer::of(2),
                Integer::of(3),
            ),
        ));
        $this->assertFalse($number->equals(
            ComplexNumber::of(
                Integer::of(3),
                Integer::of(3),
            ),
        ));
    }
}
