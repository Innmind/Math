<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use function Innmind\Math\{
    cosine,
    multiply
};
use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Integer
};

final class Angle
{
    private $firstSegment;
    private $secondSegment;
    private $degree;

    public function __construct(
        Segment $firstSegment,
        Degree $degree,
        Segment $secondSegment
    ) {
        $this->firstSegment = $firstSegment;
        $this->secondSegment = $secondSegment;
        $this->degree = $degree;
    }

    public function firstSegment(): Segment
    {
        return $this->firstSegment;
    }

    public function secondSegment(): Segment
    {
        return $this->secondSegment;
    }

    public function degree(): Degree
    {
        return $this->degree;
    }

    /**
     * It sums the segments like we would sum vectors, except here we don't use
     * vectors as it would need a plan to express a direction
     */
    public function sum(): Segment
    {
        $length = $this
            ->firstSegment
            ->length()
            ->power(new Integer(2))
            ->add(
                $this
                    ->secondSegment
                    ->length()
                    ->power(new Integer(2))
            )
            ->subtract(
                (new Integer(2))
                    ->multiplyBy($this->firstSegment->length())
                    ->multiplyBy($this->secondSegment->length())
                    ->multiplyBy(cosine($this->degree))
            )
            ->squareRoot();

        return new Segment($length);
    }

    public function scalarProduct(): NumberInterface
    {
        return multiply(
            $this->firstSegment->length(),
            $this->secondSegment->length(),
            cosine($this->degree)
        );
    }
}
