<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use function Innmind\Math\add;
use Innmind\Math\{
    Exception\VectorsMustMeOfTheSameDimension,
    Matrix,
    Algebra\Number,
    Algebra\Integer
};
use Innmind\Immutable\Sequence;

final class Vector implements \Iterator
{
    private Sequence $numbers;
    private Integer $dimension;

    public function __construct(Number $number, Number ...$numbers)
    {
        $this->numbers = new Sequence($number, ...$numbers);
        $this->dimension = new Integer($this->numbers->size());
    }

    public static function initialize(Integer $dimension, Number $value): self
    {
        return new self(...array_fill(0, $dimension->value(), $value));
    }

    /**
     * @return int|float[]
     */
    public function toArray(): array
    {
        return $this
            ->numbers
            ->map(static function(Number $number) {
                return $number->value();
            })
            ->toPrimitive();
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

        $vector->rewind();

        return $this->numbers->reduce(
            new Integer(0),
            static function(Number $carry, Number $number) use ($vector): Number {
                $value = $carry->add(
                    $number->multiplyBy($vector->current())
                );
                $vector->next();

                return $value;
            }
        );
    }

    public function multiplyBy(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $vector->rewind();
        $numbers = $this->numbers->map(static function(Number $number) use ($vector): Number {
            $number = $number->multiplyBy($vector->current());
            $vector->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function divideBy(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $vector->rewind();
        $numbers = $this->numbers->map(static function(Number $number) use ($vector): Number {
            $number = $number->divideBy($vector->current());
            $vector->next();

            return $number;
        });

        return new self(...$numbers);
    }

    public function subtract(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $vector->rewind();
        $numbers = $this->numbers->reduce(
            [],
            static function(array $numbers, Number $number) use ($vector): array {
                $numbers[] = $number->subtract($vector->current());
                $vector->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function add(self $vector): self
    {
        if (!$this->dimension()->equals($vector->dimension())) {
            throw new VectorsMustMeOfTheSameDimension;
        }

        $vector->rewind();
        $numbers = $this->numbers->reduce(
            [],
            static function(array $numbers, Number $number) use ($vector): array {
                $numbers[] = $number->add($vector->current());
                $vector->next();

                return $numbers;
            }
        );

        return new self(...$numbers);
    }

    public function power(Number $power): self
    {
        $numbers = $this->numbers->map(static function(Number $number) use ($power): Number {
            return $number->power($power);
        });

        return new self(...$numbers);
    }

    public function sum(): Number
    {
        return add(...$this->numbers);
    }

    public function foreach(callable $function): self
    {
        $this->numbers->foreach($function);

        return $this;
    }

    public function map(callable $function): self
    {
        return new self(
            ...$this->numbers->map($function)
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

        $vector->rewind();

        return $this->reduce(
            true,
            static function(bool $carry, Number $number) use ($vector): bool {
                $carry = $carry && $number->equals($vector->current());
                $vector->next();

                return $carry;
            }
        );
    }

    /**
     * First non zero number found
     */
    public function lead(): Number
    {
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

    public function current(): Number
    {
        return $this->numbers->current();
    }

    public function key(): int
    {
        return $this->numbers->key();
    }

    public function next(): void
    {
        $this->numbers->next();
    }

    public function rewind(): void
    {
        $this->numbers->rewind();
    }

    public function valid(): bool
    {
        return $this->numbers->valid();
    }
}
