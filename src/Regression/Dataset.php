<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use Innmind\Math\{
    Regression\Dataset\Point,
    Matrix,
    Matrix\Dimension,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Algebra\Number,
    Algebra\Real,
    Algebra\Integer,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Dataset
{
    /** @var Sequence<Point> */
    private Sequence $points;

    /**
     * @param Sequence<Point> $points
     */
    private function __construct(Sequence $points)
    {
        $this->points = $points;
    }

    /**
     * @psalm-pure
     *
     * @param non-empty-list<array{0: int|float|Number, 1: int|float|Number}> $values
     */
    public static function of(array $values): self
    {
        $numerize = static fn(int|float|Number $number): Number => match (true) {
            $number instanceof Number => $number,
            default => Real::of($number),
        };

        return new self(Sequence::of(...\array_map(
            static fn($coordinates) => Point::of(
                $numerize($coordinates[0]),
                $numerize($coordinates[1]),
            ),
            $values,
        )));
    }

    public function abscissas(): ColumnVector
    {
        return ColumnVector::ofSequence(
            $this->points->map(static fn($point) => $point->abscissa()),
        );
    }

    public function ordinates(): ColumnVector
    {
        return ColumnVector::ofSequence(
            $this->points->map(static fn($point) => $point->ordinate()),
        );
    }

    /**
     * @return Sequence<Point>
     */
    public function points(): Sequence
    {
        return $this->points;
    }

    public function dimension(): Dimension
    {
        /** @psalm-suppress InvalidArgument There is always at least one point */
        return Dimension::of(
            Integer::positive($this->points->size()),
            Integer::positive(2),
        );
    }
}
