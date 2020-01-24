<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use function Innmind\Math\{
    add,
    multiply,
    divide,
    subtract
};
use Innmind\Math\{
    Polynom\Polynom,
    Algebra\Number,
    Algebra\Integer,
    Matrix
};

final class LinearRegression
{
    private Polynom $polynom;
    private Number $deviation;

    public function __construct(Dataset $data)
    {
        list($slope, $intercept) = $this->compute($data);
        $this->polynom = (new Polynom($intercept))->withDegree(
            new Integer(1),
            $slope
        );
        $this->deviation = $this->buildRmsd($data);
    }

    /**
     * Return the intercept value
     *
     * @return Number
     */
    public function intercept(): Number
    {
        return $this->polynom->intercept();
    }

    /**
     * Return the slope value
     *
     * @return Number
     */
    public function slope(): Number
    {
        return $this->polynom->degree(1)->coeff();
    }

    /**
     * Compute the value at the given x value
     *
     * @param Number $x
     *
     * @return Number
     */
    public function __invoke(Number $x): Number
    {
        return ($this->polynom)($x);
    }

    public function rootMeanSquareDeviation(): Number
    {
        return $this->deviation;
    }

    /**
     * Determine the slope and intercept for the given dataset
     *
     * @see https://richardathome.wordpress.com/2006/01/25/a-php-linear-regression-function/
     *
     * @param Dataset $data
     *
     * @return array
     */
    private function compute(Dataset $data): array
    {
        $dimension = $data->dimension()->rows();
        $elements = $dimension->value();
        $x = $data->abscissas()->toArray();
        $y = $data->ordinates()->toArray();

        $xSum = $data->abscissas()->sum();
        $ySum = $data->ordinates()->sum();
        $xxSum = new Integer(0);
        $xySum = new Integer(0);

        for ($i = 0; $i < $elements; $i++) {
            $xySum = add($xySum, multiply($x[$i], $y[$i]));
            $xxSum = add($xxSum, multiply($x[$i], $x[$i]));
        }

        $slope = divide(
            subtract(
                $dimension->multiplyBy($xySum),
                $xSum->multiplyBy($ySum)
            ),
            subtract(
                $dimension->multiplyBy($xxSum),
                $xSum->power(new Integer(2))
            )
        );
        $intercept = divide(
            subtract(
                $ySum,
                $slope->multiplyBy($xSum)
            ),
            $dimension
        );

        return [$slope, $intercept];
    }

    private function buildRmsd(Dataset $dataset): Number
    {
        $values = $dataset->ordinates();
        $estimated = $dataset
            ->abscissas()
            ->map(function(Number $x): Number {
                return $this($x);
            });

        return $values
            ->subtract($estimated)
            ->power(new Integer(2))
            ->sum()
            ->divideBy(
                $values->dimension()
            )
            ->squareRoot();
    }
}
