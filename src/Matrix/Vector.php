<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimension,
    Exception\LogicException,
    Matrix,
    Algebra\Number,
    Algebra\Integer,
    Algebra\Value,
    Monoid\Addition,
    Range,
};
use Innmind\Immutable\{
    Sequence,
    SideEffect,
};

/**
 * @psalm-immutable
 */
final class Vector
{
    /** @var Sequence<Number> */
    private Sequence $numbers;
    private Integer\Positive $dimension;

    /**
     * @param Sequence<Number> $numbers
     */
    private function __construct(Sequence $numbers)
    {
        $this->numbers = $numbers;
        /** @psalm-suppress ArgumentTypeCoercion There is always at least one number in the sequence */
        $this->dimension = Integer::positive($this->numbers->size());
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number, Number ...$numbers): self
    {
        return new self(Sequence::of($number, ...$numbers));
    }

    /**
     * @psalm-pure
     */
    public static function initialize(Integer\Positive $dimension, Number $value): self
    {
        return new self(
            Range::until($dimension)->map(static fn() => $value),
        );
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
        if ($numbers->empty()) {
            throw new LogicException('Empty vector');
        }

        return new self($numbers);
    }

    public function dimension(): Integer\Positive
    {
        return $this->dimension;
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function dot(self $vector): Number
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return $this
            ->numbers
            ->zip($vector->numbers)
            ->map(static fn($pair) => $pair[0]->multiplyBy($pair[1])->collapse())
            ->fold(new Addition);
    }

    public function multiplyBy(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->multiplyBy($pair[1])->collapse()),
        );
    }

    public function divideBy(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->divideBy($pair[1])),
        );
    }

    public function subtract(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->subtract($pair[1])),
        );
    }

    public function add(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->add($pair[1])),
        );
    }

    public function power(Number $power): self
    {
        return new self(
            $this->numbers->map(static fn($number) => $number->power($power)),
        );
    }

    public function sum(): Number
    {
        return $this->numbers->fold(new Addition);
    }

    /**
     * @param callable(Number): void $function
     */
    public function foreach(callable $function): SideEffect
    {
        return $this->numbers->foreach($function);
    }

    /**
     * @param callable(Number): Number $function
     */
    public function map(callable $function): self
    {
        return new self(
            $this->numbers->map($function),
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
        return $this->numbers->reduce($carry, $reducer);
    }

    public function get(int $position): Number
    {
        return $this->numbers->get($position)->match(
            static fn($number) => $number,
            static fn() => throw new LogicException,
        );
    }

    public function equals(self $vector): bool
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            return false;
        }

        return $this
            ->numbers
            ->zip($vector->numbers)
            ->matches(static fn($pair) => $pair[0]->equals($pair[1]));
    }

    /**
     * First non zero number found
     */
    public function lead(): Number
    {
        return $this
            ->numbers
            ->find(static fn($number) => !$number->equals(Value::zero))
            ->match(
                static fn($lead) => $lead,
                static fn() => Value::zero,
            );
    }

    /**
     * @return Sequence<Number>
     */
    public function toSequence(): Sequence
    {
        return $this->numbers;
    }
}
