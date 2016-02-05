<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use Innmind\Math\Polynom\Polynom;

class LinearRegression
{
    protected $polynom;

    public function __construct(array $data)
    {
        list($slope, $intercept) = $this->compute($data);
        $this->polynom = (new Polynom($intercept))->withDegree(1, $slope);
    }

    /**
     * Return the intercept value
     *
     * @return float
     */
    public function intercept(): float
    {
        return $this->polynom->intercept();
    }

    /**
     * Return the slope value
     *
     * @return float
     */
    public function slope(): float
    {
        return $this->polynom->degree(1)->coeff();
    }

    /**
     * Compute the value at the given x value
     *
     * @param float $x
     *
     * @return float
     */
    public function __invoke(float $x): float
    {
        return call_user_func($this->polynom, $x);
    }

    /**
     * Determine the slope and intercept for the given dataset
     *
     * @see https://richardathome.wordpress.com/2006/01/25/a-php-linear-regression-function/
     *
     * @param array $data
     *
     * @return array
     */
    protected function compute(array $data): array
    {
        $count = count($data);
        $x = array_keys($data);
        $y = array_values($data);

        foreach ($x as &$value) {
            $value = (float) $value;
        }

        foreach ($y as &$value) {
            $value = (float) $value;
        }

        $xSum = array_sum($x);
        $ySum = array_sum($y);
        $xxSum = 0;
        $xySum = 0;

        for ($i = 0; $i < $count; $i++) {
            $xySum += $x[$i] * $y[$i];
            $xxSum += $x[$i] * $x[$i];
        }

        $slope = (($count * $xySum) - ($xSum * $ySum)) / (($count * $xxSum) - ($xSum * $xSum));
        $intercept = ($ySum - ($slope * $xSum)) / $count;

        return [$slope, $intercept];
    }
}
