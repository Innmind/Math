<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use Innmind\Math\{
    Regression\LinearRegression,
    Regression\Dataset,
    Algebra\Number,
    Algebra\Integer,
    Probabilities\StandardDeviation
};
use PHPUnit\Framework\TestCase;

class LinearRegressionTest extends TestCase
{
    public function testIntercept()
    {
        $r = LinearRegression::of(Dataset::of([[0, 0], [1, 1]]));
        $this->assertInstanceOf(Number::class, $r->intercept());
        $this->assertSame($r->intercept(), $r->intercept());
        $this->assertSame(0, $r->intercept()->value());

        $r = LinearRegression::of(Dataset::of([[0, 1], [1, 0]]));
        $this->assertSame(1, $r->intercept()->value());
    }

    public function testSlope()
    {
        $r = LinearRegression::of(Dataset::of([[0, 0], [1, 1]]));
        $this->assertInstanceOf(Number::class, $r->slope());
        $this->assertSame($r->slope(), $r->slope());
        $this->assertSame(1, $r->slope()->value());

        $r = LinearRegression::of(Dataset::of([[0, 1], [1, 0]]));
        $this->assertSame(-1, $r->slope()->value());
    }

    public function testComplexCase()
    {
        $r = LinearRegression::of(Dataset::of([
            [0, 0.5],
            [1, 1],
            [2, 4],
            [3, -1],
        ]));

        $this->assertSame(-0.15, $r->slope()->value());
        $this->assertSame(1.35, $r->intercept()->value());
        $this->assertEqualsWithDelta(0.0, $r(Integer::of(9))->value(), 0.0001);
    }

    public function testRootMeanSquareDeviation()
    {
        $regression = LinearRegression::of(Dataset::of([
            [0, 0.5],
            [1, 1],
            [2, 4],
            [3, -1],
        ]));

        $this->assertInstanceOf(
            Number::class,
            $regression->rootMeanSquareDeviation(),
        );
        $this->assertSame(
            1.8079684731764545,
            $regression->rootMeanSquareDeviation()->value(),
        );
    }
}
