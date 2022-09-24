<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Integer,
};

/**
 * @psalm-immutable
 */
final class Square implements Figure
{
    private Segment $side;

    private function __construct(Segment $side)
    {
        $this->side = $side;
    }

    /**
     * @psalm-pure
     */
    public static function of(Segment $side): self
    {
        return new self($side);
    }

    public function perimeter(): Number
    {
        return $this->side->length()->multiplyBy(Integer::of(4));
    }

    public function area(): Number
    {
        return $this->side->length()->multiplyBy($this->side->length());
    }

    public function side(): Segment
    {
        return $this->side;
    }
}
