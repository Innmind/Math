<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Algebra\Number
};

final class StandardDeviation
{
    private Number $deviation;

    public function __construct(Dataset $dataset)
    {
        $this->deviation = (new Variance($dataset))()->squareRoot();
    }

    public function __invoke(): Number
    {
        return $this->deviation;
    }
}
