<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimension,
    Exception\LogicException,
    Algebra\Number,
    Monoid\Algebra,
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
    /**
     * @param Sequence<Number> $numbers
     */
    private function __construct(private Sequence $numbers)
    {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Number $number, Number ...$numbers): self
    {
        return new self(Sequence::of($number, ...$numbers));
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $dimension
     */
    #[\NoDiscard]
    public static function initialize(int $dimension, Number $value): self
    {
        return new self(
            Sequence::of($value)->pad($dimension, $value),
        );
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
        if ($numbers->empty()) {
            throw new LogicException('Empty vector');
        }

        return new self($numbers);
    }

    /**
     * @return int<1, max>
     */
    #[\NoDiscard]
    public function dimension(): int
    {
        /** @var int<1, max> There's always at least one element */
        return $this->numbers->size();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    #[\NoDiscard]
    public function dot(self $vector): Number
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return $this
            ->numbers
            ->zip($vector->numbers)
            ->map(
                static fn($pair) => $pair[0]
                    ->multiplyBy($pair[1])
                    ->optimize()
                    ->memoize(),
            )
            ->fold(Algebra::addition);
    }

    #[\NoDiscard]
    public function multiplyBy(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(
                    static fn($pair) => $pair[0]
                        ->multiplyBy($pair[1])
                        ->optimize()
                        ->memoize(),
                ),
        );
    }

    #[\NoDiscard]
    public function divideBy(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->divideBy($pair[1])),
        );
    }

    #[\NoDiscard]
    public function subtract(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->subtract($pair[1])),
        );
    }

    #[\NoDiscard]
    public function add(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        return new self(
            $this
                ->numbers
                ->zip($vector->numbers)
                ->map(static fn($pair) => $pair[0]->add($pair[1])),
        );
    }

    #[\NoDiscard]
    public function power(Number $power): self
    {
        return new self(
            $this->numbers->map(static fn($number) => $number->power($power)),
        );
    }

    #[\NoDiscard]
    public function sum(): Number
    {
        return $this->numbers->fold(Algebra::addition);
    }

    /**
     * @param callable(Number): void $function
     */
    #[\NoDiscard]
    public function foreach(callable $function): SideEffect
    {
        return $this->numbers->foreach($function);
    }

    /**
     * @param callable(Number): Number $function
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function reduce($carry, callable $reducer)
    {
        return $this->numbers->reduce($carry, $reducer);
    }

    /**
     * @param int<0, max> $position
     */
    #[\NoDiscard]
    public function get(int $position): Number
    {
        return $this->numbers->get($position)->match(
            static fn($number) => $number,
            static fn() => throw new LogicException,
        );
    }

    #[\NoDiscard]
    public function equals(self $vector): bool
    {
        if ($this->dimension() !== $vector->dimension()) {
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
    #[\NoDiscard]
    public function lead(): Number
    {
        return $this
            ->numbers
            ->find(static fn($number) => !$number->equals(Number::zero()))
            ->match(
                static fn($lead) => $lead,
                static fn() => Number::zero(),
            );
    }

    /**
     * @return Sequence<Number>
     */
    #[\NoDiscard]
    public function toSequence(): Sequence
    {
        return $this->numbers;
    }
}
