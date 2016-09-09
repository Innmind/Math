<?php
declare(strict_types = 1);

namespace Innmind\Math\Vector;

use Innmind\Math\Exception\{
    VectorsMustMeOfTheSameDimensionException,
    VectorCannotBeEmptyException
};
use Innmind\Immutable\Sequence;

final class ColumnVector implements \Iterator
{
    private $numbers;

    public function __construct(float ...$numbers)
    {
        $this->numbers = new Sequence(...$numbers);

        if ($this->dimension() === 0) {
            throw new VectorCannotBeEmptyException;
        }
    }

    public function toArray(): array
    {
        return $this->numbers->toPrimitive();
    }

    public function dimension(): int
    {
        return $this->numbers->size();
    }

    public function dot(RowVector $row): float
    {
        if ($this->dimension() !== $row->dimension()) {
            throw new VectorsMustMeOfTheSameDimensionException;
        }

        $row->rewind();

        return $this->numbers->reduce(
            0,
            function (float $carry, $number) use ($row) {
                $value = $carry + $number * $row->current();
                $row->next();

                return $value;
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
