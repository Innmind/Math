<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Scope,
    Algebra\NumberInterface,
    Algebra\Number
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
    }
}
