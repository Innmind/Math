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
     * @param array<int, int|float|Number>|list<array{0: int|float|Number, 1: int|float|Number}> $values
     */
    public static function of(array $values): self
    {
        $numerize = static fn(int|float|Number $number): Number => match ($number instanceof Number) {
            true => $number,
            false => Real::of($number),
        };
        $points = [];

        foreach ($values as $x => $y) {
            $coordinates = \is_array($y) ? $y : [$x, $y];
            $points[] = Point::of(
                $numerize($coordinates[0]),
                $numerize($coordinates[1]),
            );
        }

        return new self(Sequence::of(...$points));
    }

    /**
     * @return list<list<int|float>>
     */
    public function toList(): array
    {
        return $this
            ->points
            ->map(static fn($point) => [
                $point->abscissa()->value(),
                $point->ordinate()->value(),
            ])
            ->toList();
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

    public function dimension(): Dimension
    {
        return Dimension::of(
            Integer::of($this->points->size()),
            Integer::of(2),
        );
    }
}
