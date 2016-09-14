<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use Innmind\Math\Regression\{
    LinearRegression,
    Dataset
};

class LinearRegressionTest extends \PHPUnit_Framework_TestCase
{
    public function testIntercept()
    {
        $r = new LinearRegression(Dataset::fromArray([0, 1]));
        $this->assertSame(0.0, $r->intercept());

        $r = new LinearRegression(Dataset::fromArray([1, 0]));
        $this->assertSame(1.0, $r->intercept());
    }

    public function testSlope()
    {
        $r = new LinearRegression(Dataset::fromArray([0, 1]));
        $this->assertSame(1.0, $r->slope());

        $r = new LinearRegression(Dataset::fromArray([1, 0]));
        $this->assertSame(-1.0, $r->slope());
    }

    public function testComplexCase()
    {
        $r = new LinearRegression(Dataset::fromArray([0.5, 1, 4, -1]));

        $this->assertSame(-0.15, $r->slope());
        $this->assertSame(1.35, $r->intercept());
        $this->assertSame(0.0, $r(9));
    }
}
