<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Number,
    Exception\NegativeDimensionException
};

final class Dimension
{
    private $rows;
    private $columns;
    private $string;

    public function __construct(int $rows, int $columns)
    {
        if ($rows < 0 || $columns < 0) {
            throw new NegativeDimensionException;
        }

        $this->rows = new Number($rows);
        $this->columns = new Number($columns);
        $this->string = sprintf('%s x %s', $rows, $columns);
    }

    public function rows(): NumberInterface
    {
        return $this->rows;
    }

    public function columns(): NumberInterface
    {
        return $this->columns;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
