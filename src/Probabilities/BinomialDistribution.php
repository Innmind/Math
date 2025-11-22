<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\Algebra\{
    Number,
    Factorial,
};

/**
 * @psalm-immutable
 */
final class BinomialDistribution
{
    private Number $probability;

    private function __construct(Number $probability)
    {
        $this->probability = $probability;
    }

    public function __invoke(int $trials, int $success): Number
    {
        $errors = $trials - $success;
        $coefficient = Factorial::of($trials)
            ->number()
            ->divideBy(
                Factorial::of($success)->number()->multiplyBy(
                    Factorial::of($errors)->number(),
                ),
            );

        return $coefficient
            ->multiplyBy($this->probability->power(Number::of($success)))
            ->multiplyBy(
                Number::one()
                    ->subtract($this->probability)
                    ->power(Number::of($errors)),
            );
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $probability): self
    {
        return new self($probability);
    }
}
