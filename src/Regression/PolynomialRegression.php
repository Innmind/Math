<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Polynom\Polynom,
    Matrix,
    Matrix\RowVector,
};
use Innmind\Immutable\Sequence;
use function Innmind\Immutable\unwrap;

final class PolynomialRegression
{
    private Polynom $polynom;
    private Number $deviation;

    public function __construct(Dataset $dataset, Integer $degree)
    {
        $matrix = $this->buildMatrix($dataset, $degree);
        $vector = $this->buildVector($dataset, $degree);
        $coefficients = $matrix
            ->transpose()
            ->dot($matrix)
            ->inverse()
            ->dot($matrix->transpose())
            ->dot($vector)
            ->column(0);

        $this->polynom = new Polynom($coefficients->get(0));
        $zero = new Integer(0);
        $degrees = $degree->value();

        for ($i = 1; $i <= $degrees; $i++) {
            if ($coefficients->get($i)->equals($zero)) {
                continue;
            }

            $this->polynom = $this->polynom->withDegree(
                new Integer($i),
                $coefficients->get($i),
            );
        }

        $this->deviation = $this->buildRmsd($dataset);
    }

    public function __invoke(Number $x): Number
    {
        return ($this->polynom)($x);
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function rootMeanSquareDeviation(): Number
    {
        return $this->deviation;
    }

    private function buildMatrix(Dataset $dataset, Integer $degree): Matrix
    {
        $powers = new RowVector(...numerize(...\range(0, $degree->value())));

        /** @var Sequence<RowVector> */
        $rows = $dataset
            ->abscissas()
            ->reduce(
                Sequence::of(RowVector::class),
                static function(Sequence $rows, Number $x) use ($powers): Sequence {
                    $xToThePowers = $powers->map(static function(Number $power) use ($x): Number {
                        return $x->power($power);
                    });

                    return ($rows)($xToThePowers);
                },
            );

        return new Matrix(...unwrap($rows));
    }

    private function buildVector(Dataset $dataset, Integer $degree): Matrix
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
            ->power(new Integer(2))
            ->sum()
            ->divideBy(
                $values->dimension(),
            )
            ->squareRoot();
    }
}
