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
        $r = new LinearRegression(Dataset::of([0, 1]));
        $this->assertInstanceOf(Number::class, $r->intercept());
        $this->assertSame($r->intercept(), $r->intercept());
        $this->assertSame(0, $r->intercept()->value());

        $r = new LinearRegression(Dataset::of([1, 0]));
        $this->assertSame(1, $r->intercept()->value());
    }

    public function testSlope()
    {
        $r = new LinearRegression(Dataset::of([0, 1]));
        $this->assertInstanceOf(Number::class, $r->slope());
        $this->assertSame($r->slope(), $r->slope());
        $this->assertSame(1, $r->slope()->value());

        $r = new LinearRegression(Dataset::of([1, 0]));
        $this->assertSame(-1, $r->slope()->value());
    }

    public function testComplexCase()
    {
        $r = new LinearRegression(Dataset::of([0.5, 1, 4, -1]));

        $this->assertSame(-0.15, $r->slope()->value());
        $this->assertSame(1.35, $r->intercept()->value());
        $this->assertSame(0.0, $r(new Integer(9))->value());
    }

    public function testRootMeanSquareDeviation()
    {
        $regression = new LinearRegression(Dataset::of([0.5, 1, 4, -1]));

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
