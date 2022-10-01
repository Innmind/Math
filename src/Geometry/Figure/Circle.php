<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Value,
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
            $radius->length()->multiplyBy(Value::two),
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
        return Value::pi
            ->multiplyBy(Value::two)
            ->multiplyBy($this->radius->length());
    }

    public function area(): Number
    {
        return Value::pi
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
