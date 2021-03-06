<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Integer,
    Exception\LengthMustBePositive,
};

final class Segment
{
    private Number $length;

    public function __construct(Number $length)
    {
        if (!$length->higherThan(new Integer(0))) {
            throw new LengthMustBePositive($length->toString());
        }

        $this->length = $length;
    }

    public function length(): Number
    {
        return $this->length;
    }

    public function join(self $segment, Degree $angle): Angle
    {
        return new Angle($this, $angle, $segment);
    }

    public function toString(): string
    {
        return (string) $this->length->value();
    }
}
