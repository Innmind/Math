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
 * sin(angle) = oppositeSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 * @psalm-immutable
 */
final class Sine
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
            \sin(
                $this->degree->toRadian()->number()->value(),
            ),
        );
    }

    public function toString(): string
    {
        return \sprintf('sin(%s)', $this->degree->toString());
    }
}
