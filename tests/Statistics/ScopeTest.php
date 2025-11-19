<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Scope,
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
use PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{
    public function testResult()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(2),
            Real::of(2),
            Real::of(2),
            Real::of(3),
            Real::of(5),
            Real::of(5),
            Real::of(6),
            Real::of(6),
            Real::of(7),
        );

        $this->assertInstanceOf(Number::class, $scope->result());
        $this->assertSame($scope->result(), $scope->result());
        $this->assertSame(6, $scope->result()->value());
        $this->assertSame(6, $scope->value());
    }

    public function testEquals()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );

        $this->assertTrue($scope->equals(Real::of(6)));
        $this->assertTrue($scope->equals(Real::of(6.0)));
        $this->assertFalse($scope->equals(Real::of(6.1)));
    }

    public function testHigherThan()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );

        $this->assertTrue($scope->higherThan(Real::of(5.9)));
        $this->assertFalse($scope->higherThan(Real::of(6)));
    }

    public function testAdd()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );
        $number = $scope->add(Real::of(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(72, $number->value());
    }

    public function testSubtract()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );
        $number = $scope->subtract(Real::of(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-60, $number->value());
    }

    public function testDivideBy()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );
        $number = $scope->divideBy(Real::of(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3, $number->value());
    }

    public function testMulitplyBy()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );
        $number = $scope->multiplyBy(Real::of(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(12, $number->value());
    }

    public function testRound()
    {
        $number = Scope::of(
            Real::of(1),
            Real::of(7.12),
        );

        $this->assertEquals(6.1, $number->roundUp(1)->value());
        $this->assertEquals(6.1, $number->roundDown(1)->value());
        $this->assertEquals(6.1, $number->roundEven(1)->value());
        $this->assertEquals(6.1, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7.1),
        );
        $number = $scope->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7.1),
        );
        $number = $scope->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );
        $number = $scope->modulo(Real::of(5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $scope = Scope::of(
            Real::of(-1),
            Real::of(-7),
        );
        $number = $scope->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testPower()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7),
        );
        $number = $scope->power(Real::of(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(5),
        );
        $number = $scope->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $mean = Scope::of(
            Real::of(1),
            Real::of(5),
        );
        $number = $mean->exponential();

        $this->assertInstanceOf(Exponential::class, $number);
        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Scope::of(
            Real::of(1),
            Real::of(5),
        )->binaryLogarithm();

        $this->assertInstanceOf(BinaryLogarithm::class, $number);
        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Scope::of(
            Real::of(1),
            Real::of(5),
        )->naturalLogarithm();

        $this->assertInstanceOf(NaturalLogarithm::class, $number);
        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Scope::of(
            Real::of(1),
            Real::of(5),
        )->commonLogarithm();

        $this->assertInstanceOf(CommonLogarithm::class, $number);
        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Scope::of(
            Real::of(1),
            Real::of(7),
        )->signum();

        $this->assertInstanceOf(Signum::class, $number);
        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $scope = Scope::of(
            Real::of(1),
            Real::of(7.1),
        );

        $this->assertSame('7.1 - 1', $scope->toString());
    }
}
