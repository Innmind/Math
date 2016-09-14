<?php
declare(strict_types = 1);

namespace Innmind\Math\Vector;

use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimensionException,
    Exception\VectorCannotBeEmptyException,
    Matrix
};
use Innmind\Immutable\Sequence;

final class RowVector implements \Iterator
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
    public function dot(ColumnVector $column): float
    {
        if ($this->dimension() !== $column->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $column->rewind();

        return $this->numbers->reduce(
            0,
            function(float $carry, float $number) use ($column): float {
                $value = $carry + $number * $column->current();
                $column->next();

                return $value;
            }
        );
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(ColumnVector $column): Matrix
    {
        $rows = [];

        foreach ($column as $number) {
            $values = $this->numbers->reduce(
                [],
                function(array $values, float $rowNumber) use ($number): array {
                    $values[] = $rowNumber * $number;

                    return $values;
                }
            );

            $rows[] = new RowVector(...$values);
        }

        return new Matrix(...$rows);
    }

    public function multiply(self $row): self
    {
        if ($this->dimension() !== $row->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $row->rewind();
        $numbers = $this->numbers->map(function(float $number) use ($row): float {
            $number *= $row->current();
            $row->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function divide(self $row): self
    {
        if ($this->dimension() !== $row->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $row->rewind();
        $numbers = $this->numbers->map(function(float $number) use ($row): float {
            $number /= $row->current();
            $row->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function subtract(self $row): self
    {
        if ($this->dimension() !== $row->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $row->rewind();
        $numbers = $this->numbers->reduce(
            [],
            function (array $numbers, float $number) use ($row): array {
                $numbers[] = $number - $row->current();
                $row->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function add(self $row): self
    {
        if ($this->dimension() !== $row->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $row->rewind();
        $numbers = $this->numbers->reduce(
            [],
            function (array $numbers, float $number) use ($row): array {
                $numbers[] = $number + $row->current();
                $row->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function power(int $power): self
    {
        $numbers = $this->numbers->map(function (float $number) use ($power): float {
            $coeff = $number < 0 ? -1 : 1; //to fix php messing with negative base
            $number **= $power;

            return $number * $coeff;
        });

        return new self(...$numbers);
    }

    public function sum(): float
    {
        return $this->numbers->reduce(
            0,
            function (float $carry, float $number): float {
                return $carry + $number;
            }
        );
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
