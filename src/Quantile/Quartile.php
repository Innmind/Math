<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

use Innmind\Math\Algebra\Number;

/**
 * Holds a quartile value
 * @psalm-immutable
 */
final class Quartile
{
    private function __construct(private Number $value)
    {
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $value): self
    {
        return new self($value);
    }

    /**
     * Return the quartile value
     */
    public function value(): Number
    {
        return $this->value;
    }
}
