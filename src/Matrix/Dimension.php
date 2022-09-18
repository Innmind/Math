<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

use Innmind\Math\{
    Algebra\Integer,
    Exception\DimensionMustBePositive,
};

/**
 * @psalm-immutable
 */
final class Dimension
{
    private Integer $rows;
    private Integer $columns;

    private function __construct(Integer $rows, Integer $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;

        if ($rows->value() < 0 || $columns->value() < 0) {
            throw new DimensionMustBePositive($this->toString());
        }
    }

    /**
     * @psalm-pure
     */
    public static function of(Integer $rows, Integer $columns): self
    {
        return new self($rows, $columns);
    }

    public function rows(): Integer
    {
        return $this->rows;
    }

    public function columns(): Integer
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
