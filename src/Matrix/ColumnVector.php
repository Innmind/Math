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
final class ColumnVector
{
    private function __construct(private Vector $vector)
    {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Number $number, Number ...$numbers): self
    {
        return new self(Vector::of($number, ...$numbers));
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $dimension
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public static function ofSequence(Sequence $numbers): self
    {
        return new self(Vector::ofSequence($numbers));
    }

    /**
     * @return int<1, max>
     */
    #[\NoDiscard]
    public function dimension(): int
    {
        return $this->vector->dimension();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    #[\NoDiscard]
    public function dot(RowVector $row): Number
    {
        return $this->vector->dot(Vector::ofSequence($row->toSequence()));
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    #[\NoDiscard]
    public function matrix(RowVector $row): Matrix
    {
        return Matrix::fromRows(
            $this
                ->vector
                ->toSequence()
                ->map(static fn($number) => $row->toSequence()->map(
                    static fn($rowNumber) => $number
                        ->multiplyBy($rowNumber)
                        ->optimize()
                        ->memoize(),
                ))
                ->map(RowVector::ofSequence(...)),
        );
    }

    #[\NoDiscard]
    public function multiplyBy(self $column): self
    {
        return new self(
            $this->vector->multiplyBy($column->vector),
        );
    }

    #[\NoDiscard]
    public function divideBy(self $column): self
    {
        return new self(
            $this->vector->divideBy($column->vector),
        );
    }

    #[\NoDiscard]
    public function subtract(self $column): self
    {
        return new self(
            $this->vector->subtract($column->vector),
        );
    }

    #[\NoDiscard]
    public function add(self $column): self
    {
        return new self(
            $this->vector->add($column->vector),
        );
    }

    #[\NoDiscard]
    public function power(Number $power): self
    {
        return new self(
            $this->vector->power($power),
        );
    }

    #[\NoDiscard]
    public function sum(): Number
    {
        return $this->vector->sum();
    }

    /**
     * @param callable(Number): void $function
     */
    #[\NoDiscard]
    public function foreach(callable $function): SideEffect
    {
        return $this->vector->foreach($function);
    }

    /**
     * @param callable(Number): Number $function
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function reduce($carry, callable $reducer)
    {
        return $this->vector->reduce($carry, $reducer);
    }

    /**
     * @param int<0, max> $position
     */
    #[\NoDiscard]
    public function get(int $position): Number
    {
        return $this->vector->get($position);
    }

    #[\NoDiscard]
    public function equals(self $column): bool
    {
        return $this->vector->equals($column->vector);
    }

    /**
     * First non zero number found
     */
    #[\NoDiscard]
    public function lead(): Number
    {
        return $this->vector->lead();
    }

    #[\NoDiscard]
    public function asRow(): RowVector
    {
        return RowVector::ofSequence($this->toSequence());
    }

    /**
     * @return Sequence<Number>
     */
    #[\NoDiscard]
    public function toSequence(): Sequence
    {
        return $this->vector->toSequence();
    }
}
