<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\multiply;
use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
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
        return multiply($this->side->length(), 4);
    }

    public function area(): Number
    {
        return multiply($this->side->length(), $this->side->length());
    }

    public function side(): Segment
    {
        return $this->side;
    }
}
