<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Real,
    Algebra\Integer,
    Algebra\Value,
    Polynom\Polynom,
    Matrix,
    Matrix\RowVector,
    Range,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class PolynomialRegression
{
    private Polynom $polynom;
    private Number $deviation;

    private function __construct(Dataset $dataset, Integer\Positive $degree)
    {
        $matrix = $this->buildMatrix($dataset, $degree);
        $vector = $this->buildVector($dataset);
        $coefficients = $matrix
            ->transpose()
            ->dot($matrix)
            ->inverse()
            ->dot($matrix->transpose())
            ->dot($vector)
            ->column(0);

        $this->polynom = Range::ofPositive(Integer::positive(1), $degree)
            ->zip($coefficients->toSequence()->drop(1))
            ->filter(static fn($pair) => !$pair[1]->equals(Value::zero))
            ->reduce(
                Polynom::interceptAt($coefficients->get(0)),
                static fn(Polynom $polynom, $pair) => $polynom->withDegree(
                    $pair[0],
                    $pair[1],
                ),
            );

        $this->deviation = $this->buildRmsd($dataset, $this->polynom);
    }

    public function __invoke(Number $x): Number
    {
        return ($this->polynom)($x);
    }

    /**
     * @psalm-pure
     */
    public static function of(Dataset $data, Integer\Positive $degree): self
    {
        return new self($data, $degree);
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function rootMeanSquareDeviation(): Number
    {
        return $this->deviation;
    }

    private function buildMatrix(Dataset $dataset, Integer\Positive $degree): Matrix
    {
        /** @psalm-suppress InvalidArgument */
        $powers = RowVector::ofSequence(Range::of(Integer::of(0), $degree));

        return Matrix::fromRows(
            $dataset
                ->abscissas()
                ->toSequence()
                ->map(static fn($x) => $powers->map(
                    static fn($power) => $x->power($power),
                )),
        );
    }

    private function buildVector(Dataset $dataset): Matrix
    {
        return Matrix::fromColumns(Sequence::of($dataset->ordinates()));
    }

    private function buildRmsd(Dataset $dataset, Polynom $interpolate): Number
    {
        $values = $dataset->ordinates();
        $estimated = $dataset
            ->abscissas()
            ->map(static fn($x) => $interpolate($x));

        return $values
            ->subtract($estimated)
            ->power(Value::two)
            ->sum()
            ->divideBy($values->dimension())
            ->squareRoot();
    }
}
