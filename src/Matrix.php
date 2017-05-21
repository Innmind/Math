<?php
declare(strict_types = 1);

namespace Innmind\Math;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Matrix\RowVector,
    Matrix\ColumnVector,
    Exception\VectorsMustMeOfTheSameDimension,
    Exception\MatrixMustBeSquare,
    Exception\MatricesMustBeOfTheSameDimension,
    Matrix\Dimension,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use Innmind\Immutable\{
    Sequence,
    StreamInterface,
    Stream
};

final class Matrix implements \Iterator
{
    private $dimension;
    private $rows;
    private $columns;

    public function __construct(RowVector $first, RowVector ...$rows)
    {
        $this->rows = (new Sequence($first, ...$rows))->reduce(
            new Stream(RowVector::class),
            static function(Stream $carry, RowVector $row): Stream {
                return $carry->add($row);
            }
        );

        $this
            ->rows
            ->drop(1)
            ->foreach(static function(RowVector $row) use ($first): void {
                if (!$row->dimension()->equals($first->dimension())) {
                    throw new VectorsMustMeOfTheSameDimension;
                }
            });

        $this->columns = new Stream(ColumnVector::class);
        $this->dimension = new Dimension(
            new Integer($this->rows->size()),
            $this->rows->get(0)->dimension()
        );
        $this->buildColumns();
    }

    public static function fromArray(array $values): self
    {
        $rows = [];

        foreach ($values as $numbers) {
            $rows[] = new RowVector(...numerize(...$numbers));
        }

        return new self(...$rows);
    }

    public static function fromColumns(
        ColumnVector $first,
        ColumnVector ...$columns
    ): self {
        $self = self::fromArray(
            (new Sequence($first, ...$columns))
                ->map(static function(ColumnVector $column): array {
                    return iterator_to_array($column);
                })
                ->toPrimitive()
        );

        return $self->transpose();
    }

    /**
     * Initialize a matrix to the wished dimension filled with the specified value
     */
    public static function initialize(Dimension $dimension, NumberInterface $value): self
    {
        $rows = [];

        for ($i = 0; $i < $dimension->rows()->value(); ++$i) {
            $rows[] = new RowVector(
                ...array_fill(
                    0,
                    $dimension->columns()->value(),
                    $value
                )
            );
        }

        return new self(...$rows);
    }

    public function dimension(): Dimension
    {
        return $this->dimension;
    }

    public function toArray(): array
    {
        return $this
            ->rows
            ->reduce(
                [],
                static function(array $carry, RowVector $row) {
                    $carry[] = $row->toArray();

                    return $carry;
                }
            );
    }

    public function row(int $row): RowVector
    {
        return $this->rows->get($row);
    }

    public function column(int $column): ColumnVector
    {
        return $this->columns->get($column);
    }

    /**
     * @return StreamInterface<RowVector>
     */
    public function rows(): StreamInterface
    {
        return $this->rows;
    }

    /**
     * @return StreamInterface<ColumnVector>
     */
    public function columns(): StreamInterface
    {
        return $this->columns;
    }

    public function dropRow(int $row): self
    {
        return new self(
            ...$this
                ->rows
                ->slice(0, $row)
                ->append(
                    $this->rows->slice($row + 1, $this->rows->size())
                )
        );
    }

    public function dropColumn(int $column): self
    {
        return self::fromColumns(
            ...$this
                ->columns
                ->slice(0, $column)
                ->append(
                    $this->columns->slice($column + 1, $this->columns->size())
                )
        );
    }

    public function add(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        $matrix->rewind();
        $rows = $this->rows->map(static function(RowVector $row) use ($matrix) {
            $row = $row->add($matrix->current());
            $matrix->next();

            return $row;
        });

        return new self(...$rows);
    }

    public function subtract(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        $matrix->rewind();
        $rows = $this->rows->map(static function(RowVector $row) use ($matrix) {
            $row = $row->subtract($matrix->current());
            $matrix->next();

            return $row;
        });

        return new self(...$rows);
    }

    public function multiplyBy(NumberInterface $number): self
    {
        $rows = $this->rows->reduce(
            new Sequence,
            static function(Sequence $rows, RowVector $row) use ($number): Sequence {
                return $rows->add(
                    $row->multiplyBy(
                        RowVector::initialize($row->dimension(), $number)
                    )
                );
            }
        );

        return new self(...$rows);
    }

    public function transpose(): self
    {
        $rows = $this->columns->reduce(
            [],
            static function(array $rows, ColumnVector $column): array {
                $rows[] = new RowVector(...$column);

                return $rows;
            }
        );

        return new self(...$rows);
    }

    public function dot(self $matrix): self
    {
        $rows = $this->rows->reduce(
            new Sequence,
            static function(Sequence $rows, RowVector $row) use ($matrix): Sequence {
                $newRow = $matrix
                    ->columns()
                    ->reduce(
                        new Sequence,
                        static function(Sequence $carry, ColumnVector $column) use ($row): Sequence {
                            return $carry->add(
                                $row->dot($column)
                            );
                        }
                    );

                return $rows->add($newRow);
            }
        );

        return self::fromArray($rows->toPrimitive());
    }

    public function isSquare(): bool
    {
        return $this->dimension->rows()->equals($this->dimension->columns());
    }

    public function diagonal(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquare;
        }

        $rows = $this->rows->reduce(
            new Sequence,
            static function(Sequence $rows, RowVector $row): Sequence {
                $numbers = $row->toArray();
                $newRow = array_fill(0, $row->dimension()->value(), 0);
                $index = $rows->size();
                $newRow[$index] = $numbers[$index];

                return $rows->add(new RowVector(...numerize(...$newRow)));
            }
        );

        return new self(...$rows);
    }

    public function identity(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquare;
        }

        $rows = $this->rows->reduce(
            new Sequence,
            static function(Sequence $rows, RowVector $row): Sequence {
                $newRow = array_fill(0, $row->dimension()->value(), 0);
                $newRow[$rows->size()] = 1;

                return $rows->add(new RowVector(...numerize(...$newRow)));
            }
        );

        return new self(...$rows);
    }

    public function equals(self $matrix): bool
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            return false;
        }

        $matrix->rewind();

        return $this->rows->reduce(
            true,
            static function(bool $carry, RowVector $row) use ($matrix): bool {
                $carry = $carry && $row->equals($matrix->current());
                $matrix->next();

                return $carry;
            }
        );
    }

    public function isSymmetric(): bool
    {
        return $this->equals($this->transpose());
    }

    public function isAntisymmetric(): bool
    {
        return $this
            ->multiplyBy(new Integer(-1))
            ->equals($this->transpose());
    }

    public function isInRowEchelonForm(): bool
    {
        $zero = new Integer(0);
        $leadingZeros = $this->rows->reduce(
            new Sequence,
            static function(Sequence $carry, RowVector $row) use ($zero): Sequence {
                $numbers = iterator_to_array($row);
                $dimension = $row->dimension()->value();
                $count = 0;

                for ($i = 1; $i < $dimension; $i++) {
                    if (!$numbers[$i]->equals($zero)) {
                        break;
                    }

                    ++$count;
                }

                return $carry->add($count);
            }
        );

        $previous = $leadingZeros->first();

        return $leadingZeros
            ->drop(1)
            ->reduce(
                true,
                static function(bool $carry, int $count) use (&$previous): bool {
                    $carry = $carry && $count > $previous;
                    $previous = $count;

                    return $carry;
                }
            );
    }

    public function augmentWith(self $matrix): self
    {
        return self::fromColumns(
            ...$this->columns->append($matrix->columns())
        );
    }

    /**
     * Use the property (A|In) -> (In|A⁻¹)
     *
     * The matrix augmented with its identity, by transforming the matrix part
     * to be its identity, then the identity part became the inversed matrix
     */
    public function inverse(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquare;
        }

        $matrix = $this->augmentWith($this->identity());
        $matrix = $this->reduceLowerTriangle($matrix);
        $matrix = $this->reduceUpperTriangle($matrix);

        return Matrix::fromColumns(
            ...$matrix
                ->columns()
                ->takeEnd(
                    $this->dimension->columns()->value()
                )
        );
    }

    public function current(): RowVector
    {
        return $this->rows->current();
    }

    public function key(): int
    {
        return $this->rows->key();
    }

    public function next(): void
    {
        $this->rows->next();
    }

    public function rewind(): void
    {
        $this->rows->rewind();
    }

    public function valid(): bool
    {
        return $this->rows->valid();
    }

    private function buildColumns(): void
    {
        for ($i = 0; $i < $this->dimension->columns()->value(); ++$i) {
            $values = $this->rows->reduce(
                [],
                static function(array $values, RowVector $row) use ($i) {
                    $values[] = $row->get($i);

                    return $values;
                }
            );
            $this->columns = $this->columns->add(new ColumnVector(...$values));
        }
    }

    private function reduceLowerTriangle(self $matrix): self
    {
        $rows = $matrix->rows();
        $index = 0;

        do {
            //reduce the matrix to an echelon form with leading ones
            $rows = $rows->reduce(
                $rows->clear(),
                static function(StreamInterface $rows, RowVector $row) use ($index): StreamInterface {
                    if ($rows->size() <= $index) {
                        return $rows->add($row);
                    }

                    $reference = $rows->get($index);
                    $multiplier = $row
                        ->get($index)
                        ->divideBy(
                            $reference->get($index)
                        );

                    return $rows->add(
                        $row->subtract(
                            $reference->multiplyBy(
                                RowVector::initialize(
                                    $row->dimension(),
                                    $multiplier
                                )
                            )
                        )
                    );
                }
            );

            $rows = $rows->map(static function(RowVector $row): RowVector {
                return $row->multiplyBy(
                    RowVector::initialize(
                        $row->dimension(),
                        (new Integer(1))->divideBy($row->lead())
                    )
                );
            });

            ++$index;
        } while ($index < $this->dimension()->rows()->value());

        return new self(...$rows);
    }

    private function reduceUpperTriangle(self $matrix): self
    {
        $rows = $matrix
            ->rows()
            ->reverse();
        $index = $rows->size() - 1;
        $reference = 0;

        do {
            //for each line remove remove the lines below by mutuplying them
            //by the number in j column of the row being manipulated
            $rows = $rows->reduce(
                $rows->clear(),
                static function(StreamInterface $rows, RowVector $row) use ($index, $reference): StreamInterface {
                    if ($rows->size() <= $reference) {
                        return $rows->add($row);
                    }

                    return $rows->add(
                        $row->subtract(
                            $rows->get($reference)->multiplyBy(
                                RowVector::initialize(
                                    $row->dimension(),
                                    $row->get($index)
                                )
                            )
                        )
                    );
                }
            );
            --$index;
            ++$reference;
        } while ($index >= 0);

        return new self(...$rows->reverse());
    }
}
