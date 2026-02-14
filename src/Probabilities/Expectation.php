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
final class Expectation
{
    private Number $expectation;

    private function __construct(Dataset $dataset)
    {
        $this->expectation = $dataset
            ->abscissas()
            ->multiplyBy($dataset->ordinates())
            ->sum();
    }

    #[\NoDiscard]
    public function __invoke(): Number
    {
        return $this->expectation;
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Dataset $dataset): self
    {
        return new self($dataset);
    }
}
