<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Algebra\Integer,
    Exception\NegativeDimensionException
};

final class Dimension
{
    private $rows;
    private $columns;
    private $string;

    public function __construct(Integer $rows, Integer $columns)
    {
        if ($rows->value() < 0 || $columns->value() < 0) {
            throw new NegativeDimensionException;
        }

        $this->rows = $rows;
        $this->columns = $columns;
        $this->string = sprintf('%s x %s', $rows, $columns);
    }

    public function rows(): Integer
    {
        return $this->rows;
    }

    public function columns(): Integer
    {
        return $this->columns;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
