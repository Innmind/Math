<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use function Innmind\Math\{
    divide,
    multiply,
    subtract,
};
use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
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

    public function __invoke(Integer $trials, Integer $success): Number
    {
        /** @psalm-suppress PossiblyInvalidArgument */
        $errors = Integer::of($trials->subtract($success)->value());
        $coefficient = divide(
            $trials->factorial(),
            multiply(
                $success->factorial(),
                $errors->factorial(),
            ),
        );

        return multiply(
            $coefficient,
            $this->probability->power($success),
            subtract(1, $this->probability)->power($errors),
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
