<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix,
    Algebra\Number,
    Exception\LogicException,
};
use Innmind\Immutable\{
    SideEffect,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class RowVector
{
    private function __construct(private Vector $vector)
    {
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number, Number ...$numbers): self
    {
        return new self(Vector::of($number, ...$numbers));
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $dimension
     */
    public static function initialize(int $dimension, Number $value): self
    {
        return new self(Vector::initialize($dimension, $value));
    }

    /**
     * @psalm-pure
     *
     * @param Sequence<Number> $numbers
     *
     * @throws LogicException When the sequence is empty
     */
    public static function ofSequence(Sequence $numbers): self
    {
        return new self(Vector::ofSequence($numbers));
    }

    /**
     * @return int<1, max>
     */
    public function dimension(): int
    {
        return $this->vector->dimension();
    }

    public function dot(ColumnVector $column): Number
    {
        return $this->vector->dot(Vector::ofSequence($column->toSequence()));
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function matrix(ColumnVector $column): Matrix
    {
        return Matrix::fromRows(
            $column
                ->toSequence()
                ->map(fn($number) => $this->vector->toSequence()->map(
                    static fn($rowNumber) => $rowNumber
                        ->multiplyBy($number)
                        ->optimize()
                        ->memoize(),
                ))
                ->map(self::ofSequence(...)),
        );
    }

    public function multiplyBy(self $row): self
    {
        return new self(
            $this->vector->multiplyBy($row->vector),
        );
    }

    public function divideBy(self $row): self
    {
        return new self(
            $this->vector->divideBy($row->vector),
        );
    }

    public function subtract(self $row): self
    {
        return new self(
            $this->vector->subtract($row->vector),
        );
    }

    public function add(self $row): self
    {
        return new self(
            $this->vector->add($row->vector),
        );
    }

    public function power(Number $power): self
    {
        return new self(
            $this->vector->power($power),
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
            $this->vector->map($function),
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

    /**
     * @param int<0, max> $position
     */
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

    public function asColumn(): ColumnVector
    {
        return ColumnVector::ofSequence($this->toSequence());
    }

    /**
     * @return Sequence<Number>
     */
    public function toSequence(): Sequence
    {
        return $this->vector->toSequence();
    }
}
