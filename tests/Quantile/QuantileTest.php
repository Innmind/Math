<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Quantile;

use Innmind\Math\{
    Quantile\Quantile,
    Quantile\Quartile,
    Regression\Dataset,
    Algebra\NumberInterface
};
use PHPUnit\Framework\TestCase;

class QuantileTest extends TestCase
{
    /**
     * @dataProvider datasets
     */
    public function testQuartiles($dataset, $min, $max, $mean, $median, $first, $third)
    {
        $quantile = new Quantile(Dataset::fromArray($dataset));

        $this->assertInstanceOf(Quartile::class, $quantile->min());
        $this->assertInstanceOf(NumberInterface::class, $quantile->min()->value());
        $this->assertSame(
            $min,
            $quantile->min()->value()->value()
        );
        $this->assertInstanceOf(Quartile::class, $quantile->max());
        $this->assertInstanceOf(NumberInterface::class, $quantile->max()->value());
        $this->assertSame(
            $max,
            $quantile->max()->value()->value()
        );
        $this->assertInstanceOf(NumberInterface::class, $quantile->mean());
        $this->assertSame(
            $mean,
            $quantile->mean()->value()
        );
        $this->assertInstanceOf(Quartile::class, $quantile->median());
        $this->assertInstanceOf(NumberInterface::class, $quantile->median()->value());
        $this->assertSame(
            $median,
            $quantile->median()->value()->value()
        );
        $this->assertInstanceOf(Quartile::class, $quantile->quartile(1));
        $this->assertInstanceOf(NumberInterface::class, $quantile->quartile(1)->value());
        $this->assertSame(
            $first,
            $quantile->quartile(1)->value()->value()
        );
        $this->assertInstanceOf(Quartile::class, $quantile->quartile(3));
        $this->assertInstanceOf(NumberInterface::class, $quantile->quartile(3)->value());
        $this->assertSame(
            $third,
            $quantile->quartile(3)->value()->value()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Unknown quartile 6
     */
    public function testThrowWhenAccessingUnknownQuartile()
    {
        $q = new Quantile(Dataset::fromArray([1,2,3]));

        $q->quartile(6);
    }

    public function datasets()
    {
        return [
            [
                [1,2,2,5,6,8,17,18,22,25,30,35,36,40,41],
                1,
                41,
                19.2,
                18,
                5.5,
                32.5,
            ],
            [
                range(1,12),
                1,
                12,
                6.5,
                6.5,
                3.5,
                9.5,
            ],
            [
                [2,3,5,5,6,8,8,9,9,12,12,13,13,13,14,14,15,16,17,18,19],
                2,
                19,
                11,
                12,
                7,
                14.5,
            ],
            [
                [3,5,5,6,8,8,9,9,12,12,13,13,13,14,14,15,16,17,18,19],
                3,
                19,
                11.45,
                12.5,
                8,
                14.5,
            ],
            [
                [1,2.0,3,4,5,6,7,8,9,10,11,12],
                1,
                12,
                6.5,
                6.5,
                3.5,
                9.5,
            ],
            [
                [1,2],
                1,
                2,
                1.5,
                1.5,
                1.5,
                1.5,
            ],
            [
                [1,2,3],
                1,
                3,
                2,
                2,
                1.5,
                2.5,
            ],
            [
                [1],
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
