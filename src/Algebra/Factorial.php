<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 * @internal
 */
final class Factorial
{
    /**
     * @param int<0, max> $value
     */
    private function __construct(private int $value)
    {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $value
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
