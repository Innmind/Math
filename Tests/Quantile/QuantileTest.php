<?php
declare(strict_types = 1);

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

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage Only numeric values are accepted for a quantile ('foo' given)
     */
    public function testThrowIfNotOnlyNumericGiven()
    {
        new Quantile(['foo']);
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage The dataset must contain at least one element
     */
    public function testThrowIfNotAtLeastOneElementGiven()
    {
        new Quantile([]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Unknown quartile 6
     */
    public function testThrowWhenAccessingUnknownQuartile()
    {
        $q = new Quantile([1,2,3]);

        $q->quartile(6);
    }

    public function datasets()
    {
        return [
            [
                [1,2,2,5,6,8,17,18,22,25,30,35,36,40,41],
                1.0,
                41.0,
                19.2,
                18.0,
                5.5,
                32.5,
            ],
            [
                range(1,12),
                1.0,
                12.0,
                6.5,
                6.5,
                3.5,
                9.5,
            ],
            [
                [2,3,5,5,6,8,8,9,9,12,12,13,13,13,14,14,15,16,17,18,19],
                2.0,
                19.0,
                11.0,
                12.0,
                7.0,
                14.5,
            ],
            [
                [3,5,5,6,8,8,9,9,12,12,13,13,13,14,14,15,16,17,18,19],
                3.0,
                19.0,
                11.45,
                12.5,
                8.0,
                14.5,
            ],
            [
                ['1','2.0',3,4,5,6,7,8,9,10,11,12],
                1.0,
                12.0,
                6.5,
                6.5,
                3.5,
                9.5,
            ],
            [
                [1,2],
                1.0,
                2.0,
                1.5,
                1.5,
                1.5,
                1.5,
            ],
            [
                [1,2,3],
                1.0,
                3.0,
                2.0,
                2.0,
                1.5,
                2.5,
            ],
            [
                [1],
                1.0,
                1.0,
                1.0,
                1.0,
                1.0,
                1.0,
            ],
        ];
    }
}
