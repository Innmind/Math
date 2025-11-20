<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Algebra;

use Innmind\Math\Algebra\{
    Ceil,
    Floor,
    Number,
    Addition,
    Subtraction,
    Multiplication,
    Division,
    Round,
    Modulo,
    Absolute,
    Power,
    SquareRoot,
    Exponential,
    BinaryLogarithm,
    NaturalLogarithm,
    CommonLogarithm,
    Signum,
    Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CeilTest extends TestCase
{
    public function testInterface()
    {
        $ceil = Ceil::of(Real::of(42.42));

        $this->assertInstanceOf(Number::class, $ceil);
    }

    #[DataProvider('values')]
    public function testValue($number, $expected)
    {
        $ceil = Ceil::of(Real::of($number));

        $this->assertSame($expected, $ceil->value());
    }

    public function testStringCast()
    {
        $this->assertSame(
            '43.0',
            (Ceil::of(Real::of(42.45)))->toString(),
        );
    }

    public function testEquals()
    {
        $ceil = Ceil::of(Real::of(42.45));

        $this->assertTrue($ceil->equals(Real::of(43)));
        $this->assertTrue($ceil->equals(Real::of(43.0)));
        $this->assertFalse($ceil->equals(Real::of(42)));
    }

    public function testHigherThan()
    {
        $ceil = Ceil::of(Real::of(42.45));

        $this->assertTrue($ceil->higherThan(Real::of(41.9)));
        $this->assertFalse($ceil->higherThan(Real::of(43.5)));
    }

    public function testAdd()
    {
        $ceil = Ceil::of(Real::of(42.5));
        $number = $ceil->add(Real::of(7));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(50.0, $number->value());
    }

    public function testSubtract()
    {
        $ceil = Ceil::of(Real::of(42.5));
        $number = $ceil->subtract(Real::of(7));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(36.0, $number->value());
    }

    public function testMultiplication()
    {
        $ceil = Ceil::of(Real::of(42.5));
        $number = $ceil->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(86.0, $number->value());
    }

    public function testDivision()
    {
        $ceil = Ceil::of(Real::of(42.5));
        $number = $ceil->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(21.5, $number->value());
    }

    public function testRound()
    {
        $number = Ceil::of(Real::of(42.45));

        $this->assertEquals(Round::up($number, 2), $number->roundUp(2));
        $this->assertEquals(Round::down($number, 2), $number->roundDown(2));
        $this->assertEquals(Round::even($number, 2), $number->roundEven(2));
        $this->assertEquals(Round::odd($number, 2), $number->roundOdd(2));
    }

    public function testFloor()
    {
        $ceil = Ceil::of(Real::of(42.45));
        $number = $ceil->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testCeil()
    {
        $ceil = Ceil::of(Real::of(42.45));
        $number = $ceil->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(43.0, $number->value());
    }

    public function testModulo()
    {
        $ceil = Ceil::of(Real::of(42.45));
        $number = $ceil->modulo(Real::of(2.1));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertEqualsWithDelta(1.0, $number->value(), 0.0001);
    }

    public function testAbsolute()
    {
        $ceil = Ceil::of(Real::of(-42.45));
        $number = $ceil->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(42.0, $number->value());
    }

    public function testPower()
    {
        $ceil = Ceil::of(Real::of(2.5));
        $number = $ceil->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(9.0, $number->value());
    }

    public function testSquareRoot()
    {
        $ceil = Ceil::of(Real::of(3.5));
        $number = $ceil->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $number = Ceil::of(Real::of(3.5))->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Ceil::of(Real::of(3.5))->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Ceil::of(Real::of(3.5))->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Ceil::of(Real::of(3.5))->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Ceil::of(Real::of(2))->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public static function values(): array
    {
        return [
            [42.4, 43.0],
            [42.5, 43.0],
            [42.6, 43.0],
            [42.51, 43.0],
        ];
    }

    private function assertEqualsWithDelta(
        int|float $expected,
        int|float $value,
        int|float $delta,
    ): void {
        $this->assertGreaterThanOrEqual($expected-$delta, $value);
        $this->assertLessThanOrEqual($expected+$delta, $value);
    }
}
