<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use Innmind\Math\{
    Polynom\Polynom,
    Algebra\Number,
    Algebra\Integer,
    Algebra\Value,
    Algebra\Division,
    Algebra\Subtraction,
    Algebra\Addition,
    Algebra\Multiplication,
    Algebra\Real,
    Matrix,
};

/**
 * @psalm-immutable
 */
final class LinearRegression
{
    private Polynom $polynom;
    private Number $deviation;

    private function __construct(Dataset $data)
    {
        [$slope, $intercept] = $this->compute($data);
        $this->polynom = Polynom::interceptAt($intercept)->withDegree(
            Integer::positive(1),
            $slope,
        );
        $this->deviation = $this->buildRmsd($data);
    }

    /**
     * Compute the value at the given x value
     */
    public function __invoke(Number $x): Number
    {
        return ($this->polynom)($x);
    }

    /**
     * @psalm-pure
     */
    public static function of(Dataset $data): self
    {
        return new self($data);
    }

    /**
     * Return the intercept value
     */
    public function intercept(): Number
    {
        return $this->polynom->intercept();
    }

    /**
     * Return the slope value
     */
    public function slope(): Number
    {
        return $this->polynom->degree(1)->coeff();
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
     * @return array{0: Number, 1: Number}
     */
    private function compute(Dataset $data): array
    {
        $dimension = $data->dimension()->rows();
        $elements = $dimension->value();
        $x = $data->abscissas()->toList();
        $y = $data->ordinates()->toList();

        $xSum = $data->abscissas()->sum();
        $ySum = $data->ordinates()->sum();
        $xxSum = Value::zero;
        $xySum = Value::zero;

        for ($i = 0; $i < $elements; $i++) {
            $xySum = Addition::of(
                $xySum,
                Multiplication::of(
                    Real::of($x[$i]),
                    Real::of($y[$i]),
                ),
            );
            $xxSum = Addition::of(
                $xxSum,
                Multiplication::of(
                    Real::of($x[$i]),
                    Real::of($x[$i]),
                ),
            );
        }

        $slope = Division::of(
            Subtraction::of(
                $dimension->multiplyBy($xySum),
                $xSum->multiplyBy($ySum),
            ),
            Subtraction::of(
                $dimension->multiplyBy($xxSum),
                $xSum->power(Value::two),
            ),
        );
        $intercept = Division::of(
            Subtraction::of(
                $ySum,
                $slope->multiplyBy($xSum),
            ),
            $dimension,
        );

        return [$slope, $intercept];
    }

    private function buildRmsd(Dataset $dataset): Number
    {
        $values = $dataset->ordinates();
        $estimated = $dataset
            ->abscissas()
            ->map(fn(Number $x): Number => $this($x));

        return $values
            ->subtract($estimated)
            ->power(Value::two)
            ->sum()
            ->divideBy(
                $values->dimension(),
            )
            ->squareRoot();
    }
}
