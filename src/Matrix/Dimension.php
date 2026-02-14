<?php
declare(strict_types = 1);

namespace Innmind\Math\Matrix;

/**
 * @psalm-immutable
 */
final class Dimension
{
    /**
     * @param int<1, max> $rows
     * @param int<1, max> $columns
     */
    private function __construct(
        private int $rows,
        private int $columns,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $rows
     * @param int<1, max> $columns
     */
    public static function of(int $rows, int $columns): self
    {
        return new self($rows, $columns);
    }

    /**
     * @return int<1, max>
     */
    public function rows(): int
    {
        return $this->rows;
    }

    /**
     * @return int<1, max>
     */
    public function columns(): int
    {
        return $this->columns;
    }

    public function equals(self $dimension): bool
    {
        return $this->rows === $dimension->rows() &&
            $this->columns === $dimension->columns();
    }

    public function toString(): string
    {
        return \sprintf('%s x %s', $this->rows, $this->columns);
    }
}
