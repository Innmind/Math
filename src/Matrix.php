<?php
declare(strict_types = 1);

namespace Innmind\Math;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\RowVector,
    Matrix\ColumnVector,
    Exception\VectorsMustMeOfTheSameDimensionException,
    Exception\MatrixMustBeSquareException,
    Exception\MatricesMustBeOfTheSameDimensionException,
    Matrix\Dimension,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use Innmind\Immutable\Sequence;

final class Matrix implements \Iterator
{
    private $dimension;
    private $rows;
    private $columns;

    public function __construct(RowVector $row, RowVector ...$rows)
    {
        array_unshift($rows, $row);
        $count = count($rows);

        for ($i = 1; $i < $count; ++$i) {
            if (!$rows[$i]->dimension()->equals($rows[$i - 1]->dimension())) {
                throw new VectorsMustMeOfTheSameDimensionException;
            }
        }

        $this->rows = new Sequence(...$rows);
        $this->columns = new Sequence;
        $this->dimension = new Dimension(
            new Integer($count),
            $this->rows->get(0)->dimension()
        );
        $this->buildColumns();
    }

    public static function fromArray(array $values): self
    {
        $rows = [];

        foreach ($values as $numbers) {
            $rows[] = new RowVector(...numerize(...$numbers));
        }

        return new self(...$rows);
    }

    /**
     * Initialize a matrix to the wished dimension filled with the specified value
     */
    public static function initialize(Dimension $dimension, NumberInterface $value): self
    {
        $rows = [];

        for ($i = 0; $i < $dimension->rows()->value(); ++$i) {
            $rows[] = new RowVector(
                ...array_fill(
                    0,
                    $dimension->columns()->value(),
                    $value
                )
            );
        }

        return new self(...$rows);
    }

    public function dimension(): Dimension
    {
        return $this->dimension;
    }

    public function toArray(): array
    {
        return $this
            ->rows
            ->map(function(RowVector $row) {
                return $row->toArray();
            })
            ->toPrimitive();
    }

    public function row(int $row): RowVector
    {
        return $this->rows->get($row);
    }

    public function column(int $column): ColumnVector
    {
        return $this->columns->get($column);
    }

    public function add(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimensionException;
        }

        $matrix->rewind();
        $rows = $this->rows->map(function(RowVector $row) use ($matrix) {
            $row = $row->add($matrix->current());
            $matrix->next();

            return $row;
        });

        return new self(...$rows);
    }

    public function transpose(): self
    {
        $rows = $this->columns->reduce(
            [],
            function(array $rows, ColumnVector $column): array {
                $rows[] = new RowVector(...$column);

                return $rows;
            }
        );

        return new self(...$rows);
    }

    public function multiply(self $matrix): self
    {
        $expectedM = $this->dimension->rows();
        $expectedN = $matrix->dimension()->columns();
        $rows = [];

        for ($i = 0; $i < $expectedM->value(); ++$i) {
            $row = [];

            for ($j = 0; $j < $expectedN->value(); ++$j) {
                $row[] = $this->row($i)->dot($matrix->column($j));
            }

            $rows[] = $row;
        }

        return self::fromArray($rows);
    }

    public function isSquare(): bool
    {
        return $this->dimension->rows()->equals($this->dimension->columns());
    }

    public function diagonal(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquareException;
        }

        $rows = $this->rows->reduce(
            new Sequence,
            function(Sequence $rows, RowVector $row): Sequence {
                $numbers = $row->toArray();
                $newRow = array_fill(0, $row->dimension()->value(), 0);
                $index = $rows->size();
                $newRow[$index] = $numbers[$index];

                return $rows->add(new RowVector(...numerize(...$newRow)));
            }
        );

        return new self(...$rows);
    }

    public function identity(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquareException;
        }

        $rows = $this->rows->reduce(
            new Sequence,
            function(Sequence $rows, RowVector $row): Sequence {
                $newRow = array_fill(0, $row->dimension()->value(), 0);
                $newRow[$rows->size()] = 1;

                return $rows->add(new RowVector(...numerize(...$newRow)));
            }
        );

        return new self(...$rows);
    }

    public function current(): RowVector
    {
        return $this->rows->current();
    }

    public function key(): int
    {
        return $this->rows->key();
    }

    public function next(): void
    {
        $this->rows->next();
    }

    public function rewind(): void
    {
        $this->rows->rewind();
    }

    public function valid(): bool
    {
        return $this->rows->valid();
    }

    private function buildColumns(): void
    {
        for ($i = 0; $i < $this->dimension->columns()->value(); ++$i) {
            $values = $this->rows->reduce(
                [],
                function(array $values, RowVector $row) use ($i) {
                    $values[] = $row->get($i);

                    return $values;
                }
            );
            $this->columns = $this->columns->add(new ColumnVector(...$values));
        }
    }
}
