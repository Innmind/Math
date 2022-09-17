<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix,
    Matrix\Dimension,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Algebra\Number,
    Exception\VectorsMustContainsOnlyTwoValues,
};

/**
 * @psalm-immutable
 */
final class Dataset
{
    private Matrix $matrix;

    public function __construct(RowVector ...$rows)
    {
        $this->matrix = Matrix::fromRows(...$rows);

        if ($this->matrix->dimension()->columns()->value() !== 2) {
            throw new VectorsMustContainsOnlyTwoValues;
        }
    }

    /**
     * @param array<int, int|float|Number>|list<array{0: int|float|Number, 1: int|float|Number}> $values
     */
    public static function of(array $values): self
    {
        $rows = [];

        foreach ($values as $x => $y) {
            $coordinates = \is_array($y) ? $y : [$x, $y];
            $rows[] = RowVector::of(...numerize(...$coordinates));
        }

        return new self(...$rows);
    }

    /**
     * @return list<list<int|float>>
     */
    public function toList(): array
    {
        return $this->matrix->toList();
    }

    public function abscissas(): ColumnVector
    {
        return $this->matrix->column(0);
    }

    public function ordinates(): ColumnVector
    {
        return $this->matrix->column(1);
    }

    public function dimension(): Dimension
    {
        return $this->matrix->dimension();
    }

    public function row(int $position): RowVector
    {
        return $this->matrix->row($position);
    }
}
