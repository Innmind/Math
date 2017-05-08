<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Algebra\NumberInterface
};

final class Expectation
{
    private $expectation;

    public function __construct(Dataset $dataset)
    {
        $this->expectation = $dataset
            ->abscissas()
            ->multiply($dataset->ordinates())
            ->sum();
    }

    public function __invoke(): NumberInterface
    {
        return $this->expectation;
    }
}
