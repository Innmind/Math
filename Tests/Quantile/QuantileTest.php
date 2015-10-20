<?php

namespace Innmind\Math\Tests\Quantile;

use Innmind\Math\Quantile\Quantile;

class QuantileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider datasets
     */
    public function testQuartiles($dataset, $min, $max, $mean, $median, $first, $third)
    {
        $quantile = new Quantile($dataset);

        $this->assertSame(
            $min,
            $quantile->min()->value()
        );
        $this->assertSame(
            $max,
            $quantile->max()->value()
        );
        $this->assertSame(
            $mean,
            $quantile->mean()
        );
        $this->assertSame(
            $median,
            $quantile->median()->value()
        );
        $this->assertSame(
            $first,
            $quantile->quartile(1)->value()
        );
        $this->assertSame(
            $third,
            $quantile->quartile(3)->value()
        );
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
                32.5
            ],
            [
                range(1,12),
                1,
                12,
                6.5,
                6.5,
                3.5,
                9.5
            ],
            [
                [2,3,5,5,6,8,8,9,9,12,12,13,13,13,14,14,15,16,17,18,19],
                2,
                19,
                11,
                12,
                7,
                14.5
            ],
            [
                [3,5,5,6,8,8,9,9,12,12,13,13,13,14,14,15,16,17,18,19],
                3,
                19,
                11.45,
                12.5,
                8,
                14.5
            ]
        ];
    }
}
