<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Integer,
    Exception\LengthMustBePositive,
};

/**
 * @psalm-immutable
 */
final class Segment
{
    private Number $length;

    private function __construct(Number $length)
    {
        if (!$length->higherThan(Integer::of(0))) {
            throw new LengthMustBePositive($length->toString());
        }

        $this->length = $length;
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $length): self
    {
        return new self($length);
    }

    public function length(): Number
    {
        return $this->length;
    }

    public function join(self $segment, Degree $angle): Angle
    {
        return Angle::of($this, $angle, $segment);
    }

    public function toString(): string
    {
        return (string) $this->length->value();
    }
}
