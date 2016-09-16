<?php
declare(strict_types = 1);

namespace Innmind\Math\Vector;

use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimensionException,
    Exception\VectorCannotBeEmptyException,
    Matrix
};
use Innmind\Immutable\Sequence;

final class Vector implements \Iterator
{
    private $numbers;

    public function __construct(float ...$numbers)
    {
        $this->numbers = new Sequence(...$numbers);

        if ($this->dimension() === 0) {
            throw new VectorCannotBeEmptyException;
        }
    }

    public static function initialize(int $dimension, float $value): self
    {
        return new self(...array_fill(0, $dimension, $value));
    }

    public function toArray(): array
    {
        return $this->numbers->toPrimitive();
    }

    public function dimension(): int
    {
        return $this->numbers->size();
    }

    /**
     * @see https://en.wikipedia.org/wiki/Row_and_column_vectors#Operations
     */
    public function dot(self $vector): float
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $vector->rewind();

        return $this->numbers->reduce(
            0,
            function(float $carry, float $number) use ($vector): float {
                $value = $carry + $number * $vector->current();
                $vector->next();

                return $value;
            }
        );
    }

    public function multiply(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $vector->rewind();
        $numbers = $this->numbers->map(function(float $number) use ($vector): float {
            $number *= $vector->current();
            $vector->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function divide(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $vector->rewind();
        $numbers = $this->numbers->map(function(float $number) use ($vector): float {
            $number /= $vector->current();
            $vector->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function subtract(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $vector->rewind();
        $numbers = $this->numbers->reduce(
            [],
            function(array $numbers, float $number) use ($vector): array {
                $numbers[] = $number - $vector->current();
                $vector->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function add(self $vector): self
    {
        if ($this->dimension() !== $vector->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $vector->rewind();
        $numbers = $this->numbers->reduce(
            [],
            function(array $numbers, float $number) use ($vector): array {
                $numbers[] = $number + $vector->current();
                $vector->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function power(int $power): self
    {
        $numbers = $this->numbers->map(function(float $number) use ($power): float {
            return $number ** $power;
        });

        return new self(...$numbers);
    }

    public function sum(): float
    {
        return $this->numbers->reduce(
            0,
            function(float $carry, float $number): float {
                return $carry + $number;
            }
        );
    }

    public function get(int $position): float
    {
        return $this->numbers->get($position);
    }

    public function current()
    {
        return $this->numbers->current();
    }

    public function key()
    {
        return $this->numbers->key();
    }

    public function next()
    {
        $this->numbers->next();
    }

    public function rewind()
    {
        $this->numbers->rewind();
    }

    public function valid()
    {
        return $this->numbers->valid();
    }
}
