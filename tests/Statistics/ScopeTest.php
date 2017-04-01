<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Scope,
    Algebra\NumberInterface,
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
    Algebra\SquareRoot
};
use PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{
    public function testResult()
    {
        $scope = new Scope(
            new Number(1),
            new Number(2),
            new Number(2),
            new Number(2),
            new Number(3),
            new Number(5),
            new Number(5),
            new Number(6),
            new Number(6),
            new Number(7)
        );

        $this->assertInstanceOf(NumberInterface::class, $scope->result());
        $this->assertSame($scope->result(), $scope->result());
        $this->assertSame(6, $scope->result()->value());
        $this->assertSame(6, $scope->value());
    }

    public function testEquals()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );

        $this->assertTrue($scope->equals(new Number(6)));
        $this->assertTrue($scope->equals(new Number(6.0)));
        $this->assertFalse($scope->equals(new Number(6.1)));
    }

    public function testHigherThan()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );

        $this->assertTrue($scope->higherThan(new Number(5.9)));
        $this->assertFalse($scope->higherThan(new Number(6)));
    }

    public function testAdd()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );
        $number = $scope->add(new Number(66));

        $this->assertInstanceOf(Addition::class, $number);
        $this->assertSame(72, $number->value());
    }

    public function testSubtract()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );
        $number = $scope->subtract(new Number(66));

        $this->assertInstanceOf(Subtraction::class, $number);
        $this->assertSame(-60, $number->value());
    }

    public function testDivideBy()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );
        $number = $scope->divideBy(new Number(2));

        $this->assertInstanceOf(Division::class, $number);
        $this->assertSame(3, $number->value());
    }

    public function testMulitplyBy()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );
        $number = $scope->multiplyBy(new Number(2));

        $this->assertInstanceOf(Multiplication::class, $number);
        $this->assertSame(12, $number->value());
    }

    public function testRound()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7.12)
        );
        $number = $scope->round(1);

        $this->assertInstanceOf(Round::class, $number);
        $this->assertSame(6.1, $number->value());
    }

    public function testFloor()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7.1)
        );
        $number = $scope->floor();

        $this->assertInstanceOf(Floor::class, $number);
        $this->assertSame(6.0, $number->value());
    }

    public function testCeil()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7.1)
        );
        $number = $scope->ceil();

        $this->assertInstanceOf(Ceil::class, $number);
        $this->assertSame(7.0, $number->value());
    }

    public function testModulo()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );
        $number = $scope->modulo(new Number(5));

        $this->assertInstanceOf(Modulo::class, $number);
        $this->assertSame(1.0, $number->value());
    }

    public function testAbsolute()
    {
        $scope = new Scope(
            new Number(-1),
            new Number(-7)
        );
        $number = $scope->absolute();

        $this->assertInstanceOf(Absolute::class, $number);
        $this->assertSame(6, $number->value());
    }

    public function testPower()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7)
        );
        $number = $scope->power(new Number(2));

        $this->assertInstanceOf(Power::class, $number);
        $this->assertSame(36, $number->value());
    }

    public function testSquareRoot()
    {
        $scope = new Scope(
            new Number(1),
            new Number(5)
        );
        $number = $scope->squareRoot();

        $this->assertInstanceOf(SquareRoot::class, $number);
        $this->assertSame(2.0, $number->value());
    }

    public function testStringCast()
    {
        $scope = new Scope(
            new Number(1),
            new Number(7.1)
        );

        $this->assertSame('7.1 - 1', (string) $scope);
    }
}
