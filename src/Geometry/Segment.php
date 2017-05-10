<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Integer,
    Exception\LengthMustBePositiveException
};

final class Segment
{
    private $length;

    public function __construct(NumberInterface $length)
    {
        if (!$length->higherThan(new Integer(0))) {
            throw new LengthMustBePositiveException;
        }

        $this->length = $length;
    }

    public function length(): NumberInterface
    {
        return $this->length;
    }

    public function join(self $segment, Degree $angle): Angle
    {
        return new Angle($this, $angle, $segment);
    }

    public function __toString(): string
    {
        return (string) $this->length->value();
    }
}
