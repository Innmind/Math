<?php
declare(strict_types = 1);

namespace Innmind\Math\Vector;

use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimensionException,
    Exception\VectorCannotBeEmptyException,
    Matrix
};
use Innmind\Immutable\Sequence;

final class ColumnVector implements \Iterator
{
    private $numbers;

    public function __construct(float ...$numbers)
    {
        $this->numbers = new Sequence(...$numbers);

        if ($this->dimension() === 0) {
            throw new VectorCannotBeEmptyException;
        }
    }

    public static function initialize(int $dimension, float $value): self
    {
        return new self(...array_fill(0, $dimension, $value));
    }

    public function toArray(): array
    {
        return $this->numbers->toPrimitive();
    }

    public function dimension(): int
    {
        return $this->numbers->size();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function dot(RowVector $row): float
    {
        if ($this->dimension() !== $row->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $row->rewind();

        return $this->numbers->reduce(
            0,
            function(float $carry, float $number) use ($row): float {
                $value = $carry + $number * $row->current();
                $row->next();

                return $value;
            }
        );
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(RowVector $row): Matrix
    {
        $rows = $this->numbers->map(function(float $number) use ($row): RowVector {
            $values = [];

            foreach ($row as $rowNumber) {
                $values[] = $number * $rowNumber;
            }

            return new RowVector(...$values);
        });

        return new Matrix(...$rows);
    }

    public function multiply(self $column): self
    {
        if ($this->dimension() !== $column->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $column->rewind();
        $numbers = $this->numbers->map(function(float $number) use ($column): float {
            $number *= $column->current();
            $column->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function subtract(self $column): self
    {
        if ($this->dimension() !== $column->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $column->rewind();
        $numbers = $this->numbers->reduce(
            [],
            function (array $numbers, float $number) use ($column): array {
                $numbers[] = $number - $column->current();
                $column->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function add(self $column): self
    {
        if ($this->dimension() !== $column->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $column->rewind();
        $numbers = $this->numbers->reduce(
            [],
            function (array $numbers, float $number) use ($column): array {
                $numbers[] = $number + $column->current();
                $column->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function get(int $position): float
    {
        return $this->numbers->get($position);
    }

    public function current()
    {
        return $this->numbers->current();
    }

    public function key()
    {
        return $this->numbers->key();
    }

    public function next()
    {
        $this->numbers->next();
    }

    public function rewind()
    {
        $this->numbers->rewind();
    }

    public function valid()
    {
        return $this->numbers->valid();
    }
}
