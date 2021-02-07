<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix,
    Algebra\Number,
    Algebra\Integer,
};

final class RowVector
{
    private Vector $vector;

    public function __construct(Number $number, Number ...$numbers)
    {
        $this->vector = new Vector($number, ...$numbers);
    }

    public static function initialize(Integer $dimension, Number $value): self
    {
        return new self(...\array_fill(0, $dimension->value(), $value));
    }

    /**
     * @return list<int|float>
     */
    public function toArray(): array
    {
        return $this->vector->toArray();
    }

    public function dimension(): Integer
    {
        return $this->vector->dimension();
    }

    public function dot(ColumnVector $column): Number
    {
        return $this->vector->dot(new Vector(...$column->numbers()));
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(ColumnVector $column): Matrix
    {
        $rows = [];

        foreach ($column->numbers() as $number) {
            $values = [];

            foreach ($this->vector->numbers() as $rowNumber) {
                $values[] = $rowNumber->multiplyBy($number);
            }

            $rows[] = new self(...$values);
        }

        return new Matrix(...$rows);
    }

    public function multiplyBy(self $row): self
    {
        return new self(
            ...$this->vector->multiplyBy($row->vector)->numbers(),
        );
    }

    public function divideBy(self $row): self
    {
        return new self(
            ...$this->vector->divideBy($row->vector)->numbers(),
        );
    }

    public function subtract(self $row): self
    {
        return new self(
            ...$this->vector->subtract($row->vector)->numbers(),
        );
    }

    public function add(self $row): self
    {
        return new self(
            ...$this->vector->add($row->vector)->numbers(),
        );
    }

    public function power(Number $power): self
    {
        return new self(
            ...$this->vector->power($power)->numbers(),
        );
    }

    public function sum(): Number
    {
        return $this->vector->sum();
    }

    /**
     * @param callable(Number): void $function
     */
    public function foreach(callable $function): void
    {
        $this->vector->foreach($function);
    }

    /**
     * @param callable(Number): Number $function
     */
    public function map(callable $function): self
    {
        return new self(
            ...$this->vector->map($function)->numbers(),
        );
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, Number): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->vector->reduce($carry, $reducer);
    }

    public function get(int $position): Number
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
    public function lead(): Number
    {
        return $this->vector->lead();
    }

    /**
     * @return list<Number>
     */
    public function numbers(): array
    {
        return $this->vector->numbers();
    }
}
