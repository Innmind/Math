<?php
declare(strict_types = 1);

namespace Innmind\Math\Regression;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix,
    Matrix\Dimension,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Exception\VectorsMustContainsOnlyTwoValuesException
};

final class Dataset implements \Iterator
{
    private $matrix;

    public function __construct(RowVector ...$rows)
    {
        $this->matrix = new Matrix(...$rows);

        if ($this->matrix->dimension()->columns()->value() !== 2) {
            throw new VectorsMustContainsOnlyTwoValuesException;
        }
    }

    public static function fromArray(array $values): self
    {
        $rows = [];

        foreach ($values as $x => $y) {
            $coordinates = is_array($y) ? $y : [$x, $y];
            $rows[] = new RowVector(...numerize(...$coordinates));
        }

        return new self(...$rows);
    }

    /**
     * @return int|float[]
     */
    public function toArray(): array
    {
        return $this->matrix->toArray();
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

    public function current()
    {
        return $this->matrix->current();
    }

    public function key()
    {
        return $this->matrix->key();
    }

    public function next()
    {
        $this->matrix->next();
    }

    public function rewind()
    {
        $this->matrix->rewind();
    }

    public function valid()
    {
        return $this->matrix->valid();
    }
}
