<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Algebra\Number
};

final class Expectation
{
    private Number $expectation;

    public function __construct(Dataset $dataset)
    {
        $this->expectation = $dataset
            ->abscissas()
            ->multiplyBy($dataset->ordinates())
            ->sum();
    }

    public function __invoke(): Number
    {
        return $this->expectation;
    }
}
