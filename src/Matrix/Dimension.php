<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\Algebra\Integer;

/**
 * @psalm-immutable
 */
final class Dimension
{
    private Integer\Positive $rows;
    private Integer\Positive $columns;

    private function __construct(Integer\Positive $rows, Integer\Positive $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
    }

    /**
     * @psalm-pure
     */
    public static function of(Integer\Positive $rows, Integer\Positive $columns): self
    {
        return new self($rows, $columns);
    }

    public function rows(): Integer\Positive
    {
        return $this->rows;
    }

    public function columns(): Integer\Positive
    {
        return $this->columns;
    }

    public function equals(self $dimension): bool
    {
        return $this->rows->equals($dimension->rows()) &&
            $this->columns->equals($dimension->columns());
    }

    public function toString(): string
    {
        return \sprintf('%s x %s', $this->rows->toString(), $this->columns->toString());
    }
}
