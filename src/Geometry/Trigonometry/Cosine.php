<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
};

/**
 * Given a right-angled rectangle
 *
 * cos(angle) = adjacentSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 * @psalm-immutable
 */
final class Cosine
{
    private Degree $degree;

    private function __construct(Degree $degree)
    {
        $this->degree = $degree;
    }

    /**
     * @psalm-pure
     */
    public static function of(Degree $degree): self
    {
        return new self($degree);
    }

    public function degree(): Degree
    {
        return $this->degree;
    }

    public function number(): Number
    {
        return Number::of(
            \cos(
                $this->degree->toRadian()->number()->value(),
            ),
        );
    }

    public function toString(): string
    {
        return \sprintf('cos(%s)', $this->degree->toString());
    }
}
