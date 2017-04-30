<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix,
    Algebra\NumberInterface
};

final class RowVector implements \Iterator
{
    private $vector;

    public function __construct(NumberInterface ...$numbers)
    {
        $this->vector = new Vector(...$numbers);
    }

    public static function initialize(int $dimension, NumberInterface $value): self
    {
        return new self(...array_fill(0, $dimension, $value));
    }

    /**
     * @return int|float[]
     */
    public function toArray(): array
    {
        return $this->vector->toArray();
    }

    public function dimension(): NumberInterface
    {
        return $this->vector->dimension();
    }

    public function dot(ColumnVector $column): NumberInterface
    {
        return $this->vector->dot(new Vector(...$column));
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(ColumnVector $column): Matrix
    {
        $rows = [];

        foreach ($column as $number) {
            $values = [];

            foreach ($this->vector as $rowNumber) {
                $values[] = $rowNumber->multiplyBy($number);
            }

            $rows[] = new RowVector(...$values);
        }

        return new Matrix(...$rows);
    }

    public function multiply(self $row): self
    {
        return new self(
            ...$this->vector->multiply($row->vector)
        );
    }

    public function divide(self $row): self
    {
        return new self(
            ...$this->vector->divide($row->vector)
        );
    }

    public function subtract(self $row): self
    {
        return new self(
            ...$this->vector->subtract($row->vector)
        );
    }

    public function add(self $row): self
    {
        return new self(
            ...$this->vector->add($row->vector)
        );
    }

    public function power(NumberInterface $power): self
    {
        return new self(
            ...$this->vector->power($power)
        );
    }

    public function sum(): NumberInterface
    {
        return $this->vector->sum();
    }

    public function get(int $position): NumberInterface
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
