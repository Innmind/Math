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
    private Number $value;

    private function __construct(Number $value)
    {
        $this->value = $value;
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
