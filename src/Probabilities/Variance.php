<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Matrix\ColumnVector,
    Algebra\Number,
};

/**
 * @psalm-immutable
 */
final class Variance
{
    private Number $variance;

    private function __construct(Dataset $dataset)
    {
        $expectation = Expectation::of($dataset)();
        $this->variance = $dataset
            ->abscissas()
            ->subtract(
                ColumnVector::initialize(
                    $dataset->abscissas()->dimension(),
                    $expectation,
                ),
            )
            ->power(Number::two())
            ->multiplyBy($dataset->ordinates())
            ->sum();
    }

    public function __invoke(): Number
    {
        return $this->variance;
    }

    /**
     * @psalm-pure
     */
    public static function of(Dataset $dataset): self
    {
        return new self($dataset);
    }
}
