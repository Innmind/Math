<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Scope,
    Algebra\Number,
    Algebra\Logarithm,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{
    public function testResult()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(2),
            Number::of(2),
            Number::of(2),
            Number::of(3),
            Number::of(5),
            Number::of(5),
            Number::of(6),
            Number::of(6),
            Number::of(7),
        );

        $this->assertInstanceOf(Number::class, $scope->result());
        $this->assertSame($scope->result(), $scope->result());
        $this->assertSame(6, $scope->result()->value());
    }

    public function testEquals()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();

        $this->assertTrue($scope->equals(Number::of(6)));
        $this->assertTrue($scope->equals(Number::of(6.0)));
        $this->assertFalse($scope->equals(Number::of(6.1)));
    }

    public function testHigherThan()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();

        $this->assertTrue($scope->higherThan(Number::of(5.9)));
        $this->assertFalse($scope->higherThan(Number::of(6)));
    }

    public function testAdd()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $scope->add(Number::of(66));

        $this->assertSame(72, $number->value());
    }

    public function testSubtract()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $scope->subtract(Number::of(66));

        $this->assertSame(-60, $number->value());
    }

    public function testDivideBy()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $scope->divideBy(Number::of(2));

        $this->assertSame(3, $number->value());
    }

    public function testMulitplyBy()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $scope->multiplyBy(Number::of(2));

        $this->assertSame(12, $number->value());
    }

    public function testRound()
    {
        $number = Scope::of(
            Number::of(1),
            Number::of(7.12),
        )->result();

        $this->assertEquals(6.1, $number->roundUp(1)->value());
        $this->assertEquals(6.1, $number->roundDown(1)->value());
        $this->assertEquals(6.1, $number->roundEven(1)->value());
        $this->assertEquals(6.1, $number->roundOdd(1)->value());
    }

    public function testFloor()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7.1),
        )->result();
        $number = $scope->floor();

        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7.1),
        )->result();
        $number = $scope->ceil();

        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $scope->modulo(Number::of(5));

        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $scope = Scope::of(
            Number::of(-1),
            Number::of(-7),
        )->result();
        $number = $scope->absolute();

        $this->assertSame(6, $number->value());
    }

    public function testPower()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7),
        )->result();
        $number = $scope->power(Number::of(2));

        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(5),
        )->result();
        $number = $scope->squareRoot();

        $this->assertSame(2.0, $number->value());
    }

    public function testExponential()
    {
        $mean = Scope::of(
            Number::of(1),
            Number::of(5),
        )->result();
        $number = $mean->exponential();

        $this->assertSame(\exp(4), $number->value());
    }

    public function testBinaryLogarithm()
    {
        $number = Scope::of(
            Number::of(1),
            Number::of(5),
        )
            ->result()
            ->apply(Logarithm::binary);

        $this->assertSame(\log(4, 2), $number->value());
    }

    public function testNaturalLogarithm()
    {
        $number = Scope::of(
            Number::of(1),
            Number::of(5),
        )
            ->result()
            ->apply(Logarithm::natural);

        $this->assertSame(\log(4), $number->value());
    }

    public function testCommonLogarithm()
    {
        $number = Scope::of(
            Number::of(1),
            Number::of(5),
        )
            ->result()
            ->apply(Logarithm::common);

        $this->assertSame(\log10(4), $number->value());
    }

    public function testSignum()
    {
        $number = Scope::of(
            Number::of(1),
            Number::of(7),
        )
            ->result()
            ->signum();

        $this->assertSame(1, $number->value());
    }

    public function testStringCast()
    {
        $scope = Scope::of(
            Number::of(1),
            Number::of(7.1),
        )->result();

        $this->assertSame('7.1 - 1', $scope->toString());
    }
}
