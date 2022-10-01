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
        return $this
            ->length
            ->length()
            ->multiplyBy(Value::two)
            ->add($this->width->length()->multiplyBy(Value::two));
    }

    public function area(): Number
    {
        return $this->length->length()->multiplyBy(
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
