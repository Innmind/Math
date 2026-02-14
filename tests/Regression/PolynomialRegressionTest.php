<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use Innmind\Math\{
    Regression\PolynomialRegression,
    Regression\Dataset,
    Algebra\Number,
    Polynom\Polynom
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

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

        $regression = PolynomialRegression::of($dataset, 2);
        $polynom = $regression->polynom();

        $this->assertInstanceOf(Polynom::class, $polynom);
        $this->assertEqualsWithDelta(0.0, $polynom->intercept()->value(), 0.0001);
        $this->assertFalse($polynom->degree(1)->match(
            static fn() => true,
            static fn() => false,
        ));
        $this->assertSame(1.0, $polynom->degree(2)->match(
            static fn($degree) => $degree->coeff()->value(),
            static fn() => null,
        ));
        $this->assertFalse($polynom->degree(3)->match(
            static fn() => true,
            static fn() => false,
        ));
        $this->assertSame(81.0, $polynom(Number::of(9))->value());
        $this->assertInstanceOf(
            Number::class,
            $regression->rootMeanSquareDeviation(),
        );
        $this->assertEqualsWithDelta(
            0.0,
            $regression->rootMeanSquareDeviation()->value(),
            0.0001,
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

        $regression = PolynomialRegression::of($dataset, 3);
        $polynom = $regression->polynom();

        $this->assertInstanceOf(Polynom::class, $polynom);
        $this->assertEqualsWithDelta(0.0, $polynom->intercept()->value(), 0.0001);
        $this->assertEqualsWithDelta(
            0.0,
            $polynom->degree(1)->match(
                static fn($degree) => $degree->coeff()->value(),
                static fn() => null,
            ),
            0.0001,
        );
        $this->assertEqualsWithDelta(
            0.0,
            $polynom->degree(2)->match(
                static fn($degree) => $degree->coeff()->value(),
                static fn() => null,
            ),
            0.0001,
        );
        $this->assertEqualsWithDelta(
            1.0,
            $polynom->degree(3)->match(
                static fn($degree) => $degree->coeff()->value(),
                static fn() => null,
            ),
            0.0001,
        );
        $this->assertEqualsWithDelta(729.0, $polynom(Number::of(9))->value(), 0.0001);
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

        $regression = PolynomialRegression::of($dataset, 4);
        $polynom = $regression->polynom();

        $this->assertInstanceOf(Polynom::class, $polynom);
        // values confirmed by using grapher app on mac
        $this->assertSame(0.50961538460923, $polynom->intercept()->value());
        $this->assertSame(-3.2636217948742425, $polynom->degree(1)->match(
            static fn($degree) => $degree->coeff()->value(),
            static fn() => null,
        ));
        $this->assertSame(2.8924460955725375, $polynom->degree(2)->match(
            static fn($degree) => $degree->coeff()->value(),
            static fn() => null,
        ));
        $this->assertSame(-0.47195512820532226, $polynom->degree(3)->match(
            static fn($degree) => $degree->coeff()->value(),
            static fn() => null,
        ));
        $this->assertSame(0.021452505827514123, $polynom->degree(4)->match(
            static fn($degree) => $degree->coeff()->value(),
            static fn() => null,
        ));
        $this->assertInstanceOf(
            Number::class,
            $regression->rootMeanSquareDeviation(),
        );
        $this->assertSame(
            1.0876840197440238,
            $regression->rootMeanSquareDeviation()->value(),
        );
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
