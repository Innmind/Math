<?php
declare(strict_types = 1);

namespace Innmind\Math\Vector;

use Innmind\Math\Matrix;

final class ColumnVector implements \Iterator
{
    private $vector;

    public function __construct(float ...$numbers)
    {
        $this->vector = new Vector(...$numbers);
    }

    public static function initialize(int $dimension, float $value): self
    {
        return new self(...array_fill(0, $dimension, $value));
    }

    public function toArray(): array
    {
        return $this->vector->toArray();
    }

    public function dimension(): int
    {
        return $this->vector->dimension();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function dot(RowVector $row): float
    {
        return $this->vector->dot(new Vector(...$row));
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(RowVector $row): Matrix
    {
        $rows = [];

        foreach ($this->vector as $number) {
            $values = [];

            foreach ($row as $rowNumber) {
                $values[] = $number * $rowNumber;
            }

            $rows[] = new RowVector(...$values);
        }

        return new Matrix(...$rows);
    }

    public function multiply(self $column): self
    {
        return new self(
            ...$this->vector->multiply($column->vector)
        );
    }

    public function divide(self $column): self
    {
        return new self(
            ...$this->vector->divide($column->vector)
        );
    }

    public function subtract(self $column): self
    {
        return new self(
            ...$this->vector->subtract($column->vector)
        );
    }

    public function add(self $column): self
    {
        return new self(
            ...$this->vector->add($column->vector)
        );
    }

    public function power(int $power): self
    {
        return new self(
            ...$this->vector->power($power)
        );
    }

    public function sum(): float
    {
        return $this->vector->sum();
    }

    public function get(int $position): float
    {
        return $this->vector->get($position);
    }

    public function current()
    {
        return $this->vector->current();
    }

    public function key()
    {
        return $this->vector->key();
    }

    public function next()
    {
        $this->vector->next();
    }

    public function rewind()
    {
        $this->vector->rewind();
    }

    public function valid()
    {
        return $this->vector->valid();
    }
}
