<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\{
    Regression\Dataset,
    Algebra\Number,
};

/**
 * @psalm-immutable
 */
final class StandardDeviation
{
    private Number $deviation;

    private function __construct(Dataset $dataset)
    {
        $this->deviation = Variance::of($dataset)()->squareRoot();
    }

    public function __invoke(): Number
    {
        return $this->deviation;
    }

    /**
     * @psalm-pure
     */
    public static function of(Dataset $dataset): self
    {
        return new self($dataset);
    }
}
