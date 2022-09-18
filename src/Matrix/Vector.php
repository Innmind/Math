<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimension,
    Matrix,
    Algebra\Number,
    Algebra\Integer,
    Algebra\Value,
    Monoid\Addition,
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
    private Integer $dimension;

    private function __construct(Number $number, Number ...$numbers)
    {
        $this->numbers = Sequence::of($number, ...$numbers);
        $this->dimension = Integer::of($this->numbers->size());
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
        return $this
            ->numbers
            ->map(static fn(Number $number) => $number->value())
            ->toList();
    }

    public function dimension(): Integer
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

        $value = Value::zero;

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            $value = $value->add(
                $this->get($i)->multiplyBy($vector->get($i))->collapse(),
            );
        }

        return $value;
    }

    public function multiplyBy(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $numbers = [];

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            $numbers[] = $this->get($i)->multiplyBy($vector->get($i))->collapse();
        }

        return new self(...$numbers);
    }

    public function divideBy(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $numbers = [];

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            $numbers[] = $this->get($i)->divideBy($vector->get($i));
        }

        return new self(...$numbers);
    }

    public function subtract(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $numbers = [];

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            $numbers[] = $this->get($i)->subtract($vector->get($i));
        }

        return new self(...$numbers);
    }

    public function add(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $numbers = [];

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            $numbers[] = $this->get($i)->add($vector->get($i));
        }

        return new self(...$numbers);
    }

    public function power(Number $power): self
    {
        $numbers = $this->numbers->map(static function(Number $number) use ($power): Number {
            return $number->power($power);
        });

        return new self(...$numbers->toList());
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
            ...$this->numbers->map($function)->toList(),
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
            static fn() => throw new \LogicException,
        );
    }

    public function equals(self $vector): bool
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            return false;
        }

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            if (!$this->get($i)->equals($vector->get($i))) {
                return false;
            }
        }

        return true;
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
     * @return list<Number>
     */
    public function numbers(): array
    {
        return $this->numbers->toList();
    }
}
