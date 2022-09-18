<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\multiply;
use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Number\Pi,
};

/**
 * @psalm-immutable
 */
final class Circle implements Figure
{
    private Segment $radius;
    private Segment $diameter;

    private function __construct(Segment $radius)
    {
        $this->radius = $radius;
        $this->diameter = Segment::of(
            multiply(2, $radius->length()),
        );
    }

    /**
     * @psalm-pure
     */
    public static function of(Segment $radius): self
    {
        return new self($radius);
    }

    public function perimeter(): Number
    {
        return multiply(2, new Pi, $this->radius->length());
    }

    public function area(): Number
    {
        return multiply(
            $this->radius->length(),
            $this->radius->length(),
            new Pi,
        );
    }

    public function radius(): Segment
    {
        return $this->radius;
    }

    public function diameter(): Segment
    {
        return $this->diameter;
    }
}
