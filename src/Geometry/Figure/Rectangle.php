<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\{
    add,
    multiply,
};
use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
};

/**
 * @psalm-immutable
 */
final class Rectangle implements Figure
{
    private Segment $length;
    private Segment $width;

    private function __construct(Segment $length, Segment $width)
    {
        $this->length = $length;
        $this->width = $width;
    }

    /**
     * @psalm-pure
     */
    public static function of(Segment $length, Segment $width): self
    {
        return new self($length, $width);
    }

    public function perimeter(): Number
    {
        return add(
            multiply($this->length->length(), 2),
            multiply($this->width->length(), 2),
        );
    }

    public function area(): Number
    {
        return multiply(
            $this->length->length(),
            $this->width->length(),
        );
    }

    public function length(): Segment
    {
        return $this->length;
    }

    public function width(): Segment
    {
        return $this->width;
    }
}
