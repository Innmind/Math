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
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function __invoke(NumberInterface $x): NumberInterface
    {
        return ($this->polynom)($x);
    }

    private function buildMatrix(Dataset $dataset, Integer $degree): Matrix
    {
        $powers = new RowVector(...numerize(...range(0, $degree->value())));

        $rows = $dataset
            ->abscissas()
            ->reduce(
                new Sequence,
                function(Sequence $rows, NumberInterface $x) use ($powers): Sequence {
                    $xToThePowers = $powers->map(function(NumberInterface $power) use ($x): NumberInterface {
                        return $x->power($power);
                    });

                    return $rows->add($xToThePowers);
                }
            );

        return new Matrix(...$rows);
        // $values = [];

        // for ($i = 0; $i < $degree->value(); $i++) {
        //     $row = [];

        //     for ($j = 0; $j < $degree->value(); $j++) {
        //         $row[] = $dataset
        //             ->abscissas()
        //             ->power(new Integer($i + $j))
        //             ->sum();
        //     }

        //     $values[] = $row;
        // }

        // return Matrix::fromArray($values);
    }

    private function buildVector(Dataset $dataset, Integer $degree): Matrix
    {
        return Matrix::fromColumns($dataset->ordinates());
        // $values = [];

        // for ($i = 0; $i < $degree->value(); $i++) {
        //     $values[] = $dataset
        //         ->ordinates()
        //         ->multiply(
        //             $dataset
        //                 ->abscissas()
        //                 ->power(new Integer($i))
        //         )
        //         ->sum();
        // }

        // return Matrix::fromColumns(new ColumnVector(...$values));
    }
}
