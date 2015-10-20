<?php

namespace Innmind\Math\Quantile;

/**
 * Holds a quartile value
 */
class Quartile
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Return the quartile value
     *
     * @return float
     */
    public function value()
    {
        return $this->value;
    }
}
