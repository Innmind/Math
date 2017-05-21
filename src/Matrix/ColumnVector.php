<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix,
    Algebra\NumberInterface,
    Algebra\Integer
};

final class ColumnVector implements \Iterator
{
    private $vector;

    public function __construct(
        NumberInterface $number,
        NumberInterface ...$numbers
    ) {
        $this->vector = new Vector($number, ...$numbers);
    }

    public static function initialize(Integer $dimension, NumberInterface $value): self
    {
        return new self(...array_fill(0, $dimension->value(), $value));
    }

    /**
     * @return int|float[]
     */
    public function toArray(): array
    {
        return $this->vector->toArray();
    }

    public function dimension(): Integer
    {
        return $this->vector->dimension();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function dot(RowVector $row): NumberInterface
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
                $values[] = $number->multiplyBy($rowNumber);
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

    public function foreach(callable $function): self
    {
        $this->vector->foreach($function);

        return $this;
    }

    public function map(callable $function): self
    {
        return new self(
            ...$this->vector->map($function)
        );
    }

    /**
     * @param mixed $carry
     * @param callable $reducer
     *
     * @return mixed
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->vector->reduce($carry, $reducer);
    }

    public function get(int $position): NumberInterface
    {
        return $this->vector->get($position);
    }

    public function equals(self $column): bool
    {
        return $this->vector->equals($column->vector);
    }

    /**
     * First non zero number found
     */
    public function lead(): NumberInterface
    {
        return $this->vector->lead();
    }

    public function current(): NumberInterface
    {
        return $this->vector->current();
    }

    public function key(): int
    {
        return $this->vector->key();
    }

    public function next(): void
    {
        $this->vector->next();
    }

    public function rewind(): void
    {
        $this->vector->rewind();
    }

    public function valid(): bool
    {
        return $this->vector->valid();
    }
}
