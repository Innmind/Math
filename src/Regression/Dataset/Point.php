<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression\Dataset;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Point
{
    private function __construct(
        private Number $abscissa,
        private Number $ordinate,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Number $abscissa, Number $ordinate): self
    {
        return new self($abscissa, $ordinate);
    }

    #[\NoDiscard]
    public function abscissa(): Number
    {
        return $this->abscissa;
    }

    #[\NoDiscard]
    public function ordinate(): Number
    {
        return $this->ordinate;
    }
}
