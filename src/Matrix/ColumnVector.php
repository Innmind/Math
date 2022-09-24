<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix,
    Algebra\Number,
    Algebra\Integer,
};
use Innmind\Immutable\{
    SideEffect,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class ColumnVector
{
    private Vector $vector;

    private function __construct(Number $number, Number ...$numbers)
    {
        $this->vector = Vector::of($number, ...$numbers);
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number, Number ...$numbers): self
    {
        return new self($number, ...$numbers);
    }

    public static function initialize(Integer $dimension, Number $value): self
    {
        return new self(...\array_fill(0, $dimension->value(), $value));
    }

    /**
     * @return list<int|float>
     */
    public function toList(): array
    {
        return $this->vector->toList();
    }

    public function dimension(): Integer
    {
        return $this->vector->dimension();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function dot(RowVector $row): Number
    {
        return $this->vector->dot(Vector::of(...$row->numbers()));
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(RowVector $row): Matrix
    {
        $rows = [];

        foreach ($this->vector->numbers() as $number) {
            $values = [];

            foreach ($row->numbers() as $rowNumber) {
                $values[] = $number->multiplyBy($rowNumber)->collapse();
            }

            $rows[] = RowVector::of(...$values);
        }

        return Matrix::fromRows(...$rows);
    }

    public function multiplyBy(self $column): self
    {
        return new self(
            ...$this->vector->multiplyBy($column->vector)->numbers(),
        );
    }

    public function divideBy(self $column): self
    {
        return new self(
            ...$this->vector->divideBy($column->vector)->numbers(),
        );
    }

    public function subtract(self $column): self
    {
        return new self(
            ...$this->vector->subtract($column->vector)->numbers(),
        );
    }

    public function add(self $column): self
    {
        return new self(
            ...$this->vector->add($column->vector)->numbers(),
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
    public function foreach(callable $function): SideEffect
    {
        return $this->vector->foreach($function);
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

    public function equals(self $column): bool
    {
        return $this->vector->equals($column->vector);
    }

    /**
     * First non zero number found
     */
    public function lead(): Number
    {
        return $this->vector->lead();
    }

    /**
     * @return Sequence<Number>
     */
    public function toSequence(): Sequence
    {
        return $this->vector->toSequence();
    }

    /**
     * @return list<Number>
     */
    public function numbers(): array
    {
        return $this->vector->numbers();
    }
}
