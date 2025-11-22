<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
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
            $radius->length()->multiplyBy(Number::two()),
        );
    }

    /**
     * @psalm-pure
     */
    public static function of(Segment $radius): self
    {
        return new self($radius);
    }

    #[\Override]
    public function perimeter(): Number
    {
        return Number::pi()
            ->multiplyBy(Number::two())
            ->multiplyBy($this->radius->length());
    }

    #[\Override]
    public function area(): Number
    {
        return Number::pi()
            ->multiplyBy($this->radius->length())
            ->multiplyBy($this->radius->length());
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
