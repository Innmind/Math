<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use Innmind\Math\{
    Regression\PolynomialRegression,
    Regression\Dataset,
    Algebra\Integer,
    Algebra\Number,
    Polynom\Polynom
};
use PHPUnit\Framework\TestCase;

class PolynomialRegressionTest extends TestCase
{
    public function testSquareRegression()
    {
        $dataset = Dataset::of([
            [-8, 64],
            [-4, 16],
            [0, 0],
            [2, 4],
            [4, 16],
            [8, 64],
        ]);

        $regression = new PolynomialRegression($dataset, new Integer(2));
        $polynom = $regression->polynom();

        $this->assertInstanceOf(Polynom::class, $polynom);
        $this->assertSame(0.0, $polynom->intercept()->value());
        $this->assertFalse($polynom->hasDegree(1));
        $this->assertSame(1.0, $polynom->degree(2)->coeff()->value());
        $this->assertFalse($polynom->hasDegree(3));
        $this->assertSame(81.0, $polynom(new Integer(9))->value());
        $this->assertInstanceOf(
            Number::class,
            $regression->rootMeanSquareDeviation()
        );
        $this->assertSame(
            0.0,
            $regression->rootMeanSquareDeviation()->value()
        );
    }

    public function testCubicRegression()
    {
        $dataset = Dataset::of([
            [-8, -512],
            [-4, -64],
            [0, 0],
            [2, 8],
            [4, 64],
            [8, 512],
        ]);

        $regression = new PolynomialRegression($dataset, new Integer(3));
        $polynom = $regression->polynom();

        $this->assertInstanceOf(Polynom::class, $polynom);
        $this->assertSame(0.0, $polynom->intercept()->value());
        $this->assertSame(0.0, $polynom->degree(1)->coeff()->value());
        $this->assertSame(0.0, $polynom->degree(2)->coeff()->value());
        $this->assertSame(1.0, $polynom->degree(3)->coeff()->value());
        $this->assertSame(729.0, $polynom(new Integer(9))->value());
    }

    public function testRegression()
    {
        $dataset = Dataset::of([
            [0, 0],
            [1, 1],
            [2, 2],
            [3, 4.5],
            [4, 8],
            [5, 12.5],
            [6, 12.5],
            [7, 8],
            [8, 4.5],
            [9, 2],
            [10, 1],
            [11, 0],
        ]);

        $regression = new PolynomialRegression($dataset, new Integer(4));
        $polynom = $regression->polynom();

        $this->assertInstanceOf(Polynom::class, $polynom);
        //values confirmed by using grapher app on mac
        $this->assertSame(0.50961538462331, $polynom->intercept()->value());
        $this->assertSame(-3.2636217948763, $polynom->degree(1)->coeff()->value());
        $this->assertSame(2.8924460955724, $polynom->degree(2)->coeff()->value());
        $this->assertSame(-0.47195512820531, $polynom->degree(3)->coeff()->value());
        $this->assertSame(0.021452505827514, $polynom->degree(4)->coeff()->value());
        $this->assertInstanceOf(
            Number::class,
            $regression->rootMeanSquareDeviation()
        );
        $this->assertSame(
            1.087684019744029,
            $regression->rootMeanSquareDeviation()->value()
        );
    }
}
