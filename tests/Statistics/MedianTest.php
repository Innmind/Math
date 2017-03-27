<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Median,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class MedianTest extends TestCase
{
    public function testEvenSetResult()
    {
        $scope = new Median(
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
        $this->assertSame(4, $scope->result()->value());
    }

    public function testOddSetResult()
    {
        $scope = new Median(
            new Number(1),
            new Number(2),
            new Number(2),
            new Number(2),
            new Number(3),
            $expected = new Number(5),
            new Number(5),
            new Number(6),
            new Number(6),
            new Number(7),
            new Number(8)
        );

        $this->assertInstanceOf(NumberInterface::class, $scope->result());
        $this->assertSame($scope->result(), $scope->result());
        $this->assertSame($expected, $scope->result());
        $this->assertSame(5, $scope->result()->value());
    }
}
