<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Algebra\NumberInterface
};

final class StandardDeviation
{
    private $deviation;

    public function __construct(Dataset $dataset)
    {
        $this->deviation = (new Variance($dataset))()->squareRoot();
    }

    public function __invoke(): NumberInterface
    {
        return $this->deviation;
    }
}
