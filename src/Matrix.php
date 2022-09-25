<?php
declare(strict_types = 1);

namespace Innmind\Math;

use function Innmind\Math\numerize as wrap;
use Innmind\Math\{
    Matrix\RowVector,
    Matrix\ColumnVector,
    Exception\VectorsMustMeOfTheSameDimension,
    Exception\MatrixMustBeSquare,
    Exception\MatricesMustBeOfTheSameDimension,
    Exception\DivisionByZero,
    Exception\NotANumber,
    Exception\MatrixNotInvertible,
    Exception\LogicException,
    Matrix\Dimension,
    Algebra\Number,
    Algebra\Integer,
    Algebra\Value,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Matrix
{
    private Dimension $dimension;
    /** @var Sequence<RowVector> */
    private Sequence $rows;
    /** @var Sequence<ColumnVector> */
    private Sequence $columns;

    /**
     * @param Sequence<RowVector> $rows
     */
    private function __construct(Sequence $rows)
    {
        [$first, $rest] = $rows->match(
            static fn($first, $rest) => [$first, $rest],
            static fn() => throw new LogicException('Empty matrix'),
        );
        $_ = $rest->foreach(
            static fn($row) => match ($row->dimension()->equals($first->dimension())) {
                true => null, // as expected
                false => throw new VectorsMustMeOfTheSameDimension,
            },
        );

        $this->rows = $rows;

        /** @psalm-suppress ArgumentTypeCoercion There is always at least one row */
        $this->dimension = Dimension::of(
            Integer::positive($this->rows->size()),
            $first->dimension(),
        );
        $this->columns = $this->buildColumns();
    }

    /**
     * @psalm-pure
     *
     * @param list<list<int|float|number>> $values
     */
    public static function of(array $values): self
    {
        $rows = [];

        foreach ($values as $numbers) {
            $rows[] = RowVector::of(...wrap(...$numbers));
        }

        return new self(Sequence::of(...$rows));
    }

    /**
     * @psalm-pure
     *
     * @param Sequence<RowVector> $rows
     *
     * @throws LogicException When the sequence is empty
     */
    public static function fromRows(Sequence $rows): self
    {
        return new self($rows);
    }

    /**
     * @psalm-pure
     *
     * @param Sequence<ColumnVector> $columns
     *
     * @throws LogicException When the sequence is empty
     */
    public static function fromColumns(Sequence $columns): self
    {
        return self::fromRows(
            $columns->map(static fn($column) => $column->asRow()),
        )->transpose();
    }

    /**
     * Initialize a matrix to the wished dimension filled with the specified value
     */
    public static function initialize(Dimension $dimension, Number $value): self
    {
        return new self(
            Range::of(Integer::of(1), $dimension->rows())->map(
                static fn() => RowVector::initialize($dimension->columns(), $value),
            ),
        );
    }

    public function dimension(): Dimension
    {
        return $this->dimension;
    }

    /**
     * @return list<list<int|float>>
     */
    public function toList(): array
    {
        /** @var list<list<int|float>> */
        return $this
            ->rows
            ->map(static fn($row) => $row->toList())
            ->toList();
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

    public function add(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        return new self(
            $this
                ->rows
                ->zip($matrix->rows())
                ->map(static fn($pair) => $pair[0]->add($pair[1])),
        );
    }

    public function subtract(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        return new self(
            $this
                ->rows
                ->zip($matrix->rows())
                ->map(static fn($pair) => $pair[0]->subtract($pair[1])),
        );
    }

    public function multiplyBy(Number $number): self
    {
        $multiplier = RowVector::initialize($this->dimension->columns(), $number);

        return new self(
            $this
                ->rows
                ->map(static fn($row) => $row->multiplyBy($multiplier)),
        );
    }

    public function transpose(): self
    {
        return new self(
            $this
                ->columns
                ->map(static fn($column) => $column->asRow()),
        );
    }

    public function dot(self $matrix): self
    {
        return self::of(
            $this
                ->rows
                ->map(
                    static fn($row) => $matrix
                        ->columns()
                        ->map(static fn($column) => $row->dot($column))
                        ->toList(),
                )
                ->toList(),
        );
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

        /** @var Sequence<RowVector> */
        $rows = $this->rows->reduce(
            Sequence::of(),
            static function(Sequence $rows, RowVector $row): Sequence {
                return ($rows)(RowVector::ofSequence(
                    Range::of(Integer::of(0), $row->dimension()->decrement())
                        ->map(static fn($i) => match ($i->value()) {
                            $rows->size() => $row->get($i->value()),
                            default => Value::zero,
                        }),
                ));
            },
        );

        return new self($rows);
    }

    public function identity(): self
    {
        if (!$this->isSquare()) {
            throw new MatrixMustBeSquare;
        }

        /** @var Sequence<RowVector> */
        $rows = $this->rows->reduce(
            Sequence::of(),
            static function(Sequence $rows, RowVector $row): Sequence {
                /** @psalm-suppress InvalidArgument Value is a subtype of Number */
                return ($rows)(RowVector::ofSequence(
                    Range::of(Integer::of(0), $row->dimension()->decrement())
                        ->map(static fn($i) => match ($i->value()) {
                            $rows->size() => Value::one,
                            default => Value::zero,
                        }),
                ));
            },
        );

        return new self($rows);
    }

    public function equals(self $matrix): bool
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            return false;
        }

        return $this
            ->rows
            ->zip($matrix->rows())
            ->matches(static fn($pair) => $pair[0]->equals($pair[1]));
    }

    public function isSymmetric(): bool
    {
        return $this->equals($this->transpose());
    }

    public function isAntisymmetric(): bool
    {
        return $this
            ->multiplyBy(Integer::of(-1))
            ->equals($this->transpose());
    }

    public function isInRowEchelonForm(): bool
    {
        $leadingZeros = $this->rows->map(
            static function(RowVector $row): int {
                $numbers = $row->numbers();
                $dimension = $row->dimension()->value();
                $count = 0;

                for ($i = 1; $i < $dimension; $i++) {
                    if (!$numbers[$i]->equals(Value::zero)) {
                        return $count;
                    }

                    ++$count;
                }

                return $count;
            },
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
            $this->columns->append($matrix->columns()),
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
        } catch (DivisionByZero | NotANumber $e) {
            throw new MatrixNotInvertible;
        }

        /** @psalm-suppress ArgumentTypeCoercion */
        return self::fromColumns(
            $matrix
                ->columns()
                ->takeEnd(
                    $this->dimension->columns()->value(),
                ),
        );
    }

    /**
     * @return Sequence<ColumnVector>
     */
    private function buildColumns(): Sequence
    {
        return Range::of(
            Integer::of(0),
            $this->dimension->columns()->decrement(),
        )
            ->map(fn($column) => $this->rows->map(
                static fn($row) => $row->get($column->value()),
            ))
            ->map(ColumnVector::ofSequence(...));
    }

    private function reduceLowerTriangle(self $matrix): self
    {
        $rows = $matrix->rows();
        $index = 0;

        do {
            //reduce the matrix to an echelon form with leading ones
            $echeloned = $rows->take($index + 1);
            $toEchelon = $rows->drop($index + 1);
            $reference = $echeloned->last()->match(
                static fn($reference) => $reference,
                static fn() => throw new \LogicException,
            );
            $rows = $echeloned
                ->append(
                    $toEchelon->map(static fn($row) => $row->subtract(
                        $reference->multiplyBy(
                            RowVector::initialize(
                                $row->dimension(),
                                $row // multiplier
                                    ->get($index)
                                    ->divideBy($reference->get($index)),
                            ),
                        ),
                    )),
                )
                ->map(static fn($row) => $row->multiplyBy(
                    RowVector::initialize(
                        $row->dimension(),
                        Value::one->divideBy($row->lead()),
                    ),
                ));

            ++$index;
        } while ($index < $this->dimension()->rows()->value());

        return new self($rows);
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
            $reduced = $rows->take($reference + 1);
            $toReduce = $rows->drop($reference + 1);
            $rows = $reduced->append(
                $toReduce->map(
                    static fn($row) => $reduced
                        ->last()
                        ->map(static fn($last) => $last->multiplyBy(RowVector::initialize(
                            $row->dimension(),
                            $row->get($index),
                        )))
                        ->map(static fn($last) => $row->subtract($last))
                        ->match(
                            static fn($reduced) => $reduced,
                            static fn() => throw new \LogicException,
                        ),
                ),
            );
            --$index;
            ++$reference;
        } while ($index >= 0);

        return new self($rows->reverse());
    }
}
