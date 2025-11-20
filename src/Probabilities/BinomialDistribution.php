<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use Innmind\Math\Algebra\{
    Number,
    Integer,
    Value,
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
        $errors = Integer::of($trials - $success);
        $success = Integer::of($success);
        $coefficient = Integer::of($trials)
            ->factorial()
            ->divideBy(
                $success->factorial()->multiplyBy(
                    $errors->factorial(),
                ),
            );

        return $coefficient
            ->multiplyBy($this->probability->power($success))
            ->multiplyBy(Value::one->subtract($this->probability)->power($errors));
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $probability): self
    {
        return new self($probability);
    }
}
