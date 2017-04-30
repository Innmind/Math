<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\Exception\NegativeDimensionException;

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

        $this->rows = $rows;
        $this->columns = $columns;
        $this->string = sprintf('%s x %s', $rows, $columns);
    }

    public function rows(): int
    {
        return $this->rows;
    }

    public function columns(): int
    {
        return $this->columns;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
