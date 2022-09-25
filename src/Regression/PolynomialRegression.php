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

        $this->polynom = Polynom::interceptAt($coefficients->get(0));
        $degrees = $degree->value();

        for ($i = 1; $i <= $degrees; $i++) {
            if ($coefficients->get($i)->equals(Value::zero)) {
                continue;
            }

            $this->polynom = $this->polynom->withDegree(
                Integer::positive($i),
                $coefficients->get($i),
            );
        }

        $this->deviation = $this->buildRmsd($dataset);
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
        $powers = RowVector::ofSequence(
            Sequence::of(...\range(0, $degree->value()))->map(Real::of(...)),
        );

        /** @var Sequence<RowVector> */
        $rows = $dataset
            ->abscissas()
            ->reduce(
                Sequence::of(),
                static function(Sequence $rows, Number $x) use ($powers): Sequence {
                    $xToThePowers = $powers->map(static function(Number $power) use ($x): Number {
                        return $x->power($power);
                    });

                    return ($rows)($xToThePowers);
                },
            );

        return Matrix::fromRows(...$rows->toList());
    }

    private function buildVector(Dataset $dataset): Matrix
    {
        return Matrix::fromColumns($dataset->ordinates());
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
