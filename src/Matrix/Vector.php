<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use function Innmind\Math\add;
use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimension,
    Matrix,
    Algebra\Number,
    Algebra\Integer,
};
use Innmind\Immutable\Sequence;
use function Innmind\Immutable\unwrap;

final class Vector
{
    /** @var Sequence<Number> */
    private Sequence $numbers;
    private Integer $dimension;

    public function __construct(Number $number, Number ...$numbers)
    {
        /** @var Sequence<Number> */
        $this->numbers = Sequence::of(Number::class, $number, ...$numbers);
        $this->dimension = new Integer($this->numbers->size());
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
        $values = $this->numbers->mapTo(
            'int|float',
            static fn(Number $number) => $number->value(),
        );

        return unwrap($values);
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

        $value = new Integer(0);

        for ($i = 0; $i < $this->dimension->value(); $i++) {
            $value = $value->add(
                $this->get($i)->multiplyBy($vector->get($i)),
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
            $numbers[] = $this->get($i)->multiplyBy($vector->get($i));
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

        return new self(...unwrap($numbers));
    }

    public function sum(): Number
    {
        return add(...unwrap($this->numbers));
    }

    public function foreach(callable $function): void
    {
        $this->numbers->foreach($function);
    }

    public function map(callable $function): self
    {
        return new self(
            ...unwrap($this->numbers->map($function)),
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
        return $this->numbers->reduce($carry, $reducer);
    }

    public function get(int $position): Number
    {
        return $this->numbers->get($position);
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
        /** @var Number */
        return $this->reduce(
            new Integer(0),
            static function(Number $lead, Number $number): Number {
                if (!$lead->equals(new Integer(0))) {
                    return $lead;
                }

                return $number;
            }
        );
    }

    /**
     * @return list<Number>
     */
    public function numbers(): array
    {
        return unwrap($this->numbers);
    }
}
