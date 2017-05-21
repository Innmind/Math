<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix,
    Algebra\NumberInterface,
    Algebra\Integer
};

final class RowVector implements \Iterator
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

    public function multiplyBy(self $row): self
    {
        return new self(
            ...$this->vector->multiplyBy($row->vector)
        );
    }

    public function divideBy(self $row): self
    {
        return new self(
            ...$this->vector->divideBy($row->vector)
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

    public function equals(self $row): bool
    {
        return $this->vector->equals($row->vector);
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
