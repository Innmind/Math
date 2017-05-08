<?php
declare(strict_types = 1);

namespace Innmind\Math\Probabilities;

use function Innmind\Math\{
    divide,
    multiply,
    subtract
};
use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Integer
};

final class BinomialDistribution
{
    private $probability;

    public function __construct(NumberInterface $probability)
    {
        $this->probability = $probability;
    }

    public function __invoke(
        Integer $trials,
        Integer $success
    ): NumberInterface {
        $errors = new Integer($trials->subtract($success)->value());
        $coefficient = divide(
            $trials->factorial(),
            multiply(
                $success->factorial(),
                $errors->factorial()
            )
        );

        return multiply(
            $coefficient,
            $this->probability->power($success),
            subtract(1, $this->probability)->power($errors)
        );
    }
}
