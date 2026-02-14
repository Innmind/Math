<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use Innmind\Math\{
    Polynom\Polynom,
    Algebra\Number,
    Monoid\Algebra,
};

/**
 * @psalm-immutable
 */
final class LinearRegression
{
    private Polynom $polynom;
    private Number $slope;
    private Number $deviation;

    private function __construct(Dataset $data)
    {
        [$slope, $intercept] = $this->compute($data);
        $this->polynom = Polynom::interceptAt($intercept)->withDegree(
            1,
            $slope,
        );
        $this->slope = $slope;
        $this->deviation = $this->buildRmsd($data, $this->polynom);
    }

    /**
     * Compute the value at the given x value
     */
    #[\NoDiscard]
    public function __invoke(Number $x): Number
    {
        return ($this->polynom)($x);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Dataset $data): self
    {
        return new self($data);
    }

    /**
     * Return the intercept value
     */
    #[\NoDiscard]
    public function intercept(): Number
    {
        return $this->polynom->intercept();
    }

    /**
     * Return the slope value
     */
    #[\NoDiscard]
    public function slope(): Number
    {
        return $this->slope;
    }

    #[\NoDiscard]
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
        $dimension = Number::of($data->dimension()->rows());

        $xSum = $data->abscissas()->sum();
        $ySum = $data->ordinates()->sum();
        $xxSum = $data
            ->abscissas()
            ->toSequence()
            ->map(static fn($x) => $x->multiplyBy($x))
            ->fold(Algebra::addition);
        $xySum = $data
            ->points()
            ->map(static fn($point) => $point->abscissa()->multiplyBy($point->ordinate()))
            ->fold(Algebra::addition);

        $slope = $dimension
            ->multiplyBy($xySum)
            ->subtract($xSum->multiplyBy($ySum))
            ->divideBy(
                $dimension
                    ->multiplyBy($xxSum)
                    ->subtract($xSum->power(Number::two())),
            );
        $intercept = $ySum
            ->subtract($slope->multiplyBy($xSum))
            ->divideBy($dimension);

        return [$slope, $intercept];
    }

    private function buildRmsd(Dataset $dataset, Polynom $interpolate): Number
    {
        $values = $dataset->ordinates();
        $estimated = $dataset
            ->abscissas()
            ->map(static fn($x) => $interpolate($x));

        return $values
            ->subtract($estimated)
            ->power(Number::two())
            ->sum()
            ->divideBy(Number::of($values->dimension()))
            ->squareRoot();
    }
}
