<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcCosine,
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Addition,
    Algebra\Subtraction,
    Algebra\Multiplication,
    Algebra\Division,
    Algebra\Round,
    Algebra\Floor,
    Algebra\Ceil,
    Algebra\Modulo,
    Algebra\Absolute,
    Algebra\Power,
    Algebra\SquareRoot,
    Algebra\Exponential,
    Algebra\BinaryLogarithm,
    Algebra\NaturalLogarithm,
    Algebra\CommonLogarithm,
    Algebra\Signum
};
use PHPUnit\Framework\TestCase;

class ArcCosineTest extends TestCase
{
    public function testInterface()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );

        $this->assertInstanceOf(Number::class, $acos);
        $this->assertInstanceOf(Degree::class, $acos->toDegree());
        $this->assertSame('cos⁻¹(cos(42°))', (string) $acos);
        $this->assertSame('42°', (string) $acos->toDegree());
    }

    public function testEquals()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );

        $this->assertTrue($acos->equals($acos));
        $this->assertTrue($acos->equals(new Number\Number(42.0)));
        $this->assertFalse($acos->equals(new Number\Number(0.74)));
    }

    public function testHigherThan()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );

        $this->assertFalse($acos->higherThan($acos));
        $this->assertFalse($acos->higherThan(new Number\Number(42.0)));
        $this->assertTrue($acos->higherThan(new Number\Number(0.74)));
    }

    public function testAdd()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->add(new Number\Number(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->subtract(new Number\Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->divideBy(new Number\Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->multiplyBy(new Number\Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testFloor()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->modulo(new Number\Number(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->power(new Number\Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        );
        $number = $acos->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = (new ArcCosine(
            new Cosine(new Degree(new Number\Number(42)))
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
