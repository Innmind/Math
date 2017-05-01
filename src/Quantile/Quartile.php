<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

use Innmind\Math\Algebra\NumberInterface;

/**
 * Holds a quartile value
 */
final class Quartile
{
    private $value;

    public function __construct(NumberInterface $value)
    {
        $this->value = $value;
    }

    /**
     * Return the quartile value
     *
     * @return NumberInterface
     */
    public function value(): NumberInterface
    {
        return $this->value;
    }
}
