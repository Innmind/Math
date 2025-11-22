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

    #[\Override]
    public function perimeter(): Number
    {
        return $this
            ->length
            ->length()
            ->multiplyBy(Number::two())
            ->add($this->width->length()->multiplyBy(Number::two()));
    }

    #[\Override]
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
