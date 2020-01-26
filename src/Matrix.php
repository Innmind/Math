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
    Exception\DivisionByZeroError,
    Exception\NotANumber,
    Exception\MatrixNotInvertible,
    Matrix\Dimension,
    Algebra\Number,
    Algebra\Integer
};
use Innmind\Immutable\Sequence;
use function Innmind\Immutable\unwrap;

final class Matrix
{
    private Dimension $dimension;
    /** @var Sequence<RowVector> */
    private Sequence $rows;
    /** @var Sequence<ColumnVector> */
    private Sequence $columns;

    public function __construct(RowVector $first, RowVector ...$rows)
    {
        $this->rows = Sequence::of(RowVector::class, $first, ...$rows);

        $this
            ->rows
            ->drop(1)
            ->foreach(static function(RowVector $row) use ($first): void {
                if (!$row->dimension()->equals($first->dimension())) {
                    throw new VectorsMustMeOfTheSameDimension;
                }
            });

        $this->columns = Sequence::of(ColumnVector::class);
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
        $numbers = Sequence::of(ColumnVector::class, $first, ...$columns)->mapTo(
            'array',
            static function(ColumnVector $column): array {
                return $column->numbers();
            },
        );

        $self = self::fromArray(unwrap($numbers));

        return $self->transpose();
    }

    /**
     * Initialize a matrix to the wished dimension filled with the specified value
     */
    public static function initialize(Dimension $dimension, Number $value): self
    {
        $rows = [];
        $count = $dimension->rows()->value();

        for ($i = 0; $i < $count; ++$i) {
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
     * @return Sequence<RowVector>
     */
    public function rows(): Sequence
    {
        return $this->rows;
    }

    /**
     * @return Sequence<ColumnVector>
     */
    public function columns(): Sequence
    {
        return $this->columns;
    }

    public function dropRow(int $row): self
    {
        return new self(
            ...unwrap($this
                ->rows
                ->slice(0, $row)
                ->append(
                    $this->rows->slice($row + 1, $this->rows->size())
                )),
        );
    }

    public function dropColumn(int $column): self
    {
        return self::fromColumns(
            ...unwrap($this
                ->columns
                ->slice(0, $column)
                ->append(
                    $this->columns->slice($column + 1, $this->columns->size())
                )),
        );
    }

    public function add(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        $numberOfRows = $this->rows->size();
        $rows = [];

        for ($i=0; $i < $numberOfRows; $i++) {
            $rows[] = $this->row($i)->add($matrix->row($i));
        }

        return new self(...$rows);
    }

    public function subtract(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        $numberOfRows = $this->rows->size();
        $rows = [];

        for ($i=0; $i < $numberOfRows; $i++) {
            $rows[] = $this->row($i)->subtract($matrix->row($i));
        }

        return new self(...$rows);
    }

    public function multiplyBy(Number $number): self
    {
        $multiplier = RowVector::initialize($this->row(0)->dimension(), $number);

        $rows = $this->rows->map(
            static fn(RowVector $row): RowVector => $row->multiplyBy($multiplier),
        );

        return new self(...unwrap($rows));
    }

    public function transpose(): self
    {
        $rows = $this->columns->reduce(
            [],
            static function(array $rows, ColumnVector $column): array {
                $rows[] = new RowVector(...$column->numbers());

                return $rows;
            }
        );

        return new self(...$rows);
    }

    public function dot(self $matrix): self
    {
        $rows = $this->rows->reduce(
            Sequence::of('array'),
            static function(Sequence $rows, RowVector $row) use ($matrix): Sequence {
                $newRow = $matrix
                    ->columns()
                    ->reduce(
                        Sequence::of(Number::class),
                        static function(Sequence $carry, ColumnVector $column) use ($row): Sequence {
                            return ($carry)($row->dot($column));
                        }
                    );

                return ($rows)(unwrap($newRow));
            }
        );

        return self::fromArray(unwrap($rows));
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
            Sequence::of(RowVector::class),
            static function(Sequence $rows, RowVector $row): Sequence {
                $numbers = $row->toArray();
                $newRow = array_fill(0, $row->dimension()->value(), 0);
                $index = $rows->size();
                $newRow[$index] = $numbers[$index];

                return ($rows)(new RowVector(...numerize(...$newRow)));
            }
        );

        return new self(...unwrap($rows));
    }

    public function identity(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquare;
        }

        $rows = $this->rows->reduce(
            Sequence::of(RowVector::class),
            static function(Sequence $rows, RowVector $row): Sequence {
                $newRow = array_fill(0, $row->dimension()->value(), 0);
                $newRow[$rows->size()] = 1;

                return ($rows)(new RowVector(...numerize(...$newRow)));
            }
        );

        return new self(...unwrap($rows));
    }

    public function equals(self $matrix): bool
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            return false;
        }

        $numberOfRows = $this->rows->size();

        for ($i = 0; $i < $numberOfRows; $i++) {
            if (!$this->row($i)->equals($matrix->row($i))) {
                return false;
            }
        }

        return true;
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
            Sequence::ints(),
            static function(Sequence $carry, RowVector $row) use ($zero): Sequence {
                $numbers = $row->numbers();
                $dimension = $row->dimension()->value();
                $count = 0;

                for ($i = 1; $i < $dimension; $i++) {
                    if (!$numbers[$i]->equals($zero)) {
                        break;
                    }

                    ++$count;
                }

                return ($carry)($count);
            }
        );

        $numberOfRows = $this->rows->size();
        $previous = $leadingZeros->first();

        for ($i = 1; $i < $numberOfRows; $i++) {
            $count = $leadingZeros->get($i);

            if ($count <= $previous) {
                return false;
            }

            $previous = $count;
        }

        return true;
    }

    public function augmentWith(self $matrix): self
    {
        return self::fromColumns(
            ...unwrap($this->columns->append($matrix->columns())),
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

        try {
            $matrix = $this->reduceLowerTriangle($matrix);
            $matrix = $this->reduceUpperTriangle($matrix);
        } catch (DivisionByZeroError | NotANumber $e) {
            throw new MatrixNotInvertible;
        }

        return Matrix::fromColumns(
            ...unwrap($matrix
                ->columns()
                ->takeEnd(
                    $this->dimension->columns()->value()
                )),
        );
    }

    private function buildColumns(): void
    {
        $columns = $this->dimension->columns()->value();

        for ($i = 0; $i < $columns; ++$i) {
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
            [$echeloned, $toEchelon] = unwrap($rows->splitAt($index + 1));
            $reference = $echeloned->last();
            $rows = $toEchelon->reduce(
                $echeloned,
                static function(Sequence $rows, RowVector $row) use ($reference, $index): Sequence {
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

        return new self(...unwrap($rows));
    }

    private function reduceUpperTriangle(self $matrix): self
    {
        $rows = $matrix
            ->rows()
            ->reverse();
        $index = $rows->size() - 1;
        $reference = 0;

        do {
            //for each line remove the lines below by mutuplying them
            //by the number in j column of the row being manipulated
            [$reduced, $toReduce] = unwrap($rows->splitAt($reference + 1));
            $rows = $toReduce->reduce(
                $reduced,
                static function(Sequence $rows, RowVector $row) use ($index, $reduced): Sequence {
                    return $rows->add(
                        $row->subtract(
                            $reduced->last()->multiplyBy(
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

        return new self(...unwrap($rows->reverse()));
    }
}
