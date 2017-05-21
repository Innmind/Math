<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Integer,
    Polynom\Polynom,
    Matrix,
    Matrix\RowVector
};
use Innmind\Immutable\Sequence;

final class PolynomialRegression
{
    private $polynom;
    private $deviation;

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

        for ($i = 1; $i <= $degree->value(); $i++) {
            if ($coefficients->get($i)->equals($zero)) {
                continue;
            }

            $this->polynom = $this->polynom->withDegree(
                new Integer($i),
                $coefficients->get($i)
            );
        }

        $this->deviation = $this->buildRmsd($dataset);
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function __invoke(NumberInterface $x): NumberInterface
    {
        return ($this->polynom)($x);
    }

    public function rootMeanSquareDeviation(): NumberInterface
    {
        return $this->deviation;
    }

    private function buildMatrix(Dataset $dataset, Integer $degree): Matrix
    {
        $powers = new RowVector(...numerize(...range(0, $degree->value())));

        $rows = $dataset
            ->abscissas()
            ->reduce(
                new Sequence,
                static function(Sequence $rows, NumberInterface $x) use ($powers): Sequence {
                    $xToThePowers = $powers->map(static function(NumberInterface $power) use ($x): NumberInterface {
                        return $x->power($power);
                    });

                    return $rows->add($xToThePowers);
                }
            );

        return new Matrix(...$rows);
    }

    private function buildVector(Dataset $dataset, Integer $degree): Matrix
    {
        return Matrix::fromColumns($dataset->ordinates());
    }

    private function buildRmsd(Dataset $dataset): NumberInterface
    {
        $dataset = Matrix::fromColumns(
            $dataset
                ->abscissas()
                ->map(function(NumberInterface $x): NumberInterface {
                    return $this($x);
                }),
            $dataset->ordinates()
        );

        return $dataset
            ->column(0)
            ->subtract($dataset->column(1))
            ->power(new Integer(2))
            ->sum()
            ->divideBy(
                $dataset->column(0)->dimension()
            )
            ->squareRoot();
    }
}
