<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Matrix\ColumnVector,
    Algebra\Number,
    Algebra\Integer,
};

/**
 * @psalm-immutable
 */
final class Variance
{
    private Number $variance;

    public function __construct(Dataset $dataset)
    {
        $expectation = (new Expectation($dataset))();
        $this->variance = $dataset
            ->abscissas()
            ->subtract(
                ColumnVector::initialize(
                    $dataset->abscissas()->dimension(),
                    $expectation,
                ),
            )
            ->power(new Integer(2))
            ->multiplyBy($dataset->ordinates())
            ->sum();
    }

    public function __invoke(): Number
    {
        return $this->variance;
    }
}
