<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

use Innmind\Math\Algebra\Number;

/**
 * Holds a quartile value
 */
final class Quartile
{
    private Number $value;

    public function __construct(Number $value)
    {
        $this->value = $value;
    }

    /**
     * Return the quartile value
     *
     * @return Number
     */
    public function value(): Number
    {
        return $this->value;
    }
}
