<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use Innmind\Math\{
    Algebra\Number,
    Polynom\Polynom,
    Matrix,
    Matrix\RowVector,
    Range,
    Exception\LogicException,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class PolynomialRegression
{
    private Polynom $polynom;
    private Number $deviation;

    /**
     * @param int<1, max> $degree
     */
    private function __construct(Dataset $dataset, int $degree)
    {
        $matrix = $this->buildMatrix($dataset, $degree);
        $vector = $this->buildVector($dataset);
        $coefficients = $matrix
            ->transpose()
            ->dot($matrix)
            ->inverse()
            ->dot($matrix->transpose())
            ->dot($vector)
            ->columns()
            ->first()
            ->match(
                static fn($coefficients) => $coefficients,
                static fn() => throw new LogicException('Empty matrix'),
            );

        $this->polynom = Range::ofPositive(1, $degree)
            ->zip($coefficients->toSequence()->drop(1))
            ->filter(static fn($pair) => !$pair[1]->equals(Number::zero()))
            ->reduce(
                Polynom::interceptAt($coefficients->get(0)),
                static fn(Polynom $polynom, $pair) => $polynom->withDegree(
                    $pair[0],
                    $pair[1],
                ),
            );

        $this->deviation = $this->buildRmsd($dataset, $this->polynom);
    }

    #[\NoDiscard]
    public function __invoke(Number $x): Number
    {
        return ($this->polynom)($x);
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $degree
     */
    #[\NoDiscard]
    public static function of(Dataset $data, int $degree): self
    {
        return new self($data, $degree);
    }

    #[\NoDiscard]
    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    #[\NoDiscard]
    public function rootMeanSquareDeviation(): Number
    {
        return $this->deviation;
    }

    /**
     * @param int<1, max> $degree
     */
    private function buildMatrix(Dataset $dataset, int $degree): Matrix
    {
        $powers = RowVector::ofSequence(Range::of(0, $degree)->map(Number::of(...)));

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
            ->power(Number::two())
            ->sum()
            ->divideBy(Number::of($values->dimension()))
            ->squareRoot();
    }
}
