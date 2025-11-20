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
    Algebra\Signum,
    Algebra\Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ArcCosineTest extends TestCase
{
    public function testInterface()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );

        $this->assertInstanceOf(Number::class, $acos);
        $this->assertInstanceOf(Degree::class, $acos->toDegree());
        $this->assertSame('cos⁻¹(cos(42°))', $acos->toString());
        $this->assertSame('42°', $acos->toDegree()->toString());
    }

    public function testEquals()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );

        $this->assertTrue($acos->equals($acos));
        $this->assertTrue($acos->equals(Real::of(42.0)));
        $this->assertFalse($acos->equals(Real::of(0.74)));
    }

    public function testHigherThan()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );

        $this->assertFalse($acos->higherThan($acos));
        $this->assertFalse($acos->higherThan(Real::of(42.0)));
        $this->assertTrue($acos->higherThan(Real::of(0.74)));
    }

    public function testAdd()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->add(Real::of(1));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testSubtract()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-24.0, $number->value());
    }

    public function testDivideBy()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.0, $number->value());
    }

    public function testMulitplyBy()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(84.0, $number->value());
    }

    public function testRound()
    {
        $number = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );

        $this->assertEquals(42.0, $number->roundUp(1)->value());
        $this->assertEquals(42.0, $number->roundDown(1)->value());
        $this->assertEquals(42.0, $number->roundEven(1)->value());
        $this->assertEquals(42.0, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testCeil()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testModulo()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->modulo(Real::of(3));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(0.0, $number->value());
    }

    public function testAbsolute()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(1764.0, $number->value());
    }

    public function testSquareRoot()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(6.48074069840786, $number->value());
    }

    public function testExponential()
    {
        $acos = ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        );
        $number = $acos->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(1.739274941520501E+18, $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        ))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(5.392317422778761, $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        ))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(3.7376696182833684, $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        ))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(1.6232492903979006, $number->value());
    }

    public function testSignum()
    {
        $number = (ArcCosine::of(
            Cosine::of(Degree::of(Real::of(42))),
        ))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }
}
