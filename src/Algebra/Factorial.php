<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\FactorialMustBePositive;

/**
 * @psalm-immutable
 * @internal
 */
final class Factorial
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new FactorialMustBePositive((string) $value);
        }

        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    public static function of(int $value): self
    {
        return new self($value);
    }

    public function number(): Number
    {
        if ($this->value < 2) {
            return Number::one();
        }

        $i = $this->value;
        $factorial = Number::of($i);

        do {
            $factorial = $factorial
                ->multiplyBy(Number::of(--$i))
                ->memoize();
        } while ($i > 1);

        return $factorial;
    }

    public function toString(): string
    {
        return $this->value.'!';
    }
}
