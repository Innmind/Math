<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Quantile;

use Innmind\Math\{
    Quantile\Quantile,
    Quantile\Quartile,
    Regression\Dataset,
    Algebra\Number,
    Exception\UnknownQuartile,
};
use PHPUnit\Framework\TestCase;

class QuantileTest extends TestCase
{
    /**
     * @dataProvider datasets
     */
    public function testQuartiles($dataset, $min, $max, $mean, $median, $first, $third)
    {
        $quantile = Quantile::of(Dataset::of($dataset));

        $this->assertInstanceOf(Quartile::class, $quantile->min());
        $this->assertInstanceOf(Number::class, $quantile->min()->value());
        $this->assertSame(
            $min,
            $quantile->min()->value()->value(),
        );
        $this->assertInstanceOf(Quartile::class, $quantile->max());
        $this->assertInstanceOf(Number::class, $quantile->max()->value());
        $this->assertSame(
            $max,
            $quantile->max()->value()->value(),
        );
        $this->assertInstanceOf(Number::class, $quantile->mean());
        $this->assertSame(
            $mean,
            $quantile->mean()->value(),
        );
        $this->assertInstanceOf(Quartile::class, $quantile->median());
        $this->assertInstanceOf(Number::class, $quantile->median()->value());
        $this->assertSame(
            $median,
            $quantile->median()->value()->value(),
        );
        $this->assertInstanceOf(Quartile::class, $quantile->quartile(1));
        $this->assertInstanceOf(Number::class, $quantile->quartile(1)->value());
        $this->assertSame(
            $first,
            $quantile->quartile(1)->value()->value(),
        );
        $this->assertInstanceOf(Quartile::class, $quantile->quartile(3));
        $this->assertInstanceOf(Number::class, $quantile->quartile(3)->value());
        $this->assertSame(
            $third,
            $quantile->quartile(3)->value()->value(),
        );
    }

    public function testThrowWhenAccessingUnknownQuartile()
    {
        $q = Quantile::of(Dataset::of([1, 2, 3]));

        $this->expectException(\UnhandledMatchError::class);
        $this->expectExceptionMessage('Unhandled match case 6');

        $q->quartile(6);
    }

    public function datasets()
    {
        return [
            [
                [
                    [0, 1],
                    [1, 2],
                    [2, 2],
                    [3, 5],
                    [4, 6],
                    [5, 8],
                    [6, 17],
                    [7, 18],
                    [8, 22],
                    [9, 25],
                    [10, 30],
                    [11, 35],
                    [12, 36],
                    [13, 40],
                    [14, 41],
                ],
                1,
                41,
                19.2,
                18,
                5.5,
                32.5,
            ],
            [
                \array_combine(\range(0, 11), \range(1, 12)),
                1,
                12,
                6.5,
                6.5,
                3.5,
                9.5,
            ],
            [
                [
                    [0, 2],
                    [1, 3],
                    [2, 5],
                    [3, 5],
                    [4, 6],
                    [5, 8],
                    [6, 8],
                    [7, 9],
                    [8, 9],
                    [9, 12],
                    [10, 12],
                    [11, 13],
                    [12, 13],
                    [13, 13],
                    [14, 14],
                    [15, 14],
                    [16, 15],
                    [17, 16],
                    [18, 17],
                    [19, 18],
                    [20, 19],
                ],
                2,
                19,
                11,
                12,
                7,
                14.5,
            ],
            [
                [
                    [0, 3],
                    [1, 5],
                    [2, 5],
                    [3, 6],
                    [4, 8],
                    [5, 8],
                    [6, 9],
                    [7, 9],
                    [8, 12],
                    [9, 12],
                    [10, 13],
                    [11, 13],
                    [12, 13],
                    [13, 14],
                    [14, 14],
                    [15, 15],
                    [16, 16],
                    [17, 17],
                    [18, 18],
                    [19, 19],
                ],
                3,
                19,
                11.45,
                12.5,
                8,
                14.5,
            ],
            [
                [
                    [0, 1],
                    [1, 2.0],
                    [2, 3],
                    [3, 4],
                    [4, 5],
                    [5, 6],
                    [6, 7],
                    [7, 8],
                    [8, 9],
                    [9, 10],
                    [10, 11],
                    [11, 12],
                ],
                1,
                12,
                6.5,
                6.5,
                3.5,
                9.5,
            ],
            [
                [[0, 1], [1, 2]],
                1,
                2,
                1.5,
                1.5,
                1.5,
                1.5,
            ],
            [
                [[0, 1], [1, 2], [2, 3]],
                1,
                3,
                2,
                2,
                1.5,
                2.5,
            ],
            [
                [[0, 1]],
                1,
                1,
                1,
                1,
                1,
                1,
            ],
        ];
    }
}
