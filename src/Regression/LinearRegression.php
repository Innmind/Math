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
    Algebra\NumberInterface,
    Algebra\Integer
};

final class LinearRegression
{
    private $polynom;

    public function __construct(Dataset $data)
    {
        list($slope, $intercept) = $this->compute($data);
        $this->polynom = (new Polynom($intercept))->withDegree(
            new Integer(1),
            $slope
        );
    }

    /**
     * Return the intercept value
     *
     * @return NumberInterface
     */
    public function intercept(): NumberInterface
    {
        return $this->polynom->intercept();
    }

    /**
     * Return the slope value
     *
     * @return NumberInterface
     */
    public function slope(): NumberInterface
    {
        return $this->polynom->degree(1)->coeff();
    }

    /**
     * Compute the value at the given x value
     *
     * @param NumberInterface $x
     *
     * @return NumberInterface
     */
    public function __invoke(NumberInterface $x): NumberInterface
    {
        return ($this->polynom)($x);
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
        $x = $data->abscissas()->toArray();
        $y = $data->ordinates()->toArray();

        $xSum = $data->abscissas()->sum();
        $ySum = $data->ordinates()->sum();
        $xxSum = new Integer(0);
        $xySum = new Integer(0);

        for ($i = 0; $i < $dimension->value(); $i++) {
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
}
