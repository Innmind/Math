<?php
declare(strict_types = 1);

namespace Innmind\Math;

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
            static fn($row) => match ($row->dimension() === $first->dimension()) {
                true => null, // as expected
                false => throw new VectorsMustMeOfTheSameDimension,
            },
        );

        $this->rows = $rows;

        /** @psalm-suppress InvalidArgument There is always at least one row */
        $this->dimension = Dimension::of(
            $this->rows->size(),
            $first->dimension(),
        );
        $this->columns = $this->buildColumns();
    }

    /**
     * @psalm-pure
     *
     * @param non-empty-list<non-empty-list<int|float|Number>> $values
     */
    #[\NoDiscard]
    public static function of(array $values): self
    {
        $numerize = static fn(int|float|Number $number): Number => match (true) {
            $number instanceof Number => $number,
            default => Number::of($number),
        };

        return new self(
            Sequence::of(...$values)
                ->map(static fn($values) => Sequence::of(...$values)->map($numerize))
                ->map(RowVector::ofSequence(...)),
        );
    }

    /**
     * @psalm-pure
     *
     * @param Sequence<RowVector> $rows
     *
     * @throws LogicException When the sequence is empty
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public static function fromColumns(Sequence $columns): self
    {
        return self::fromRows(
            $columns->map(static fn($column) => $column->asRow()),
        )->transpose();
    }

    /**
     * Initialize a matrix to the wished dimension filled with the specified value
     *
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function initialize(Dimension $dimension, Number $value): self
    {
        return new self(
            Range::of(1, $dimension->rows())->map(
                static fn() => RowVector::initialize($dimension->columns(), $value),
            ),
        );
    }

    #[\NoDiscard]
    public function dimension(): Dimension
    {
        return $this->dimension;
    }

    /**
     * @return Sequence<ColumnVector>
     */
    #[\NoDiscard]
    public function columns(): Sequence
    {
        return $this->columns;
    }

    #[\NoDiscard]
    public function add(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        return new self(
            $this
                ->rows
                ->zip($matrix->rows)
                ->map(static fn($pair) => $pair[0]->add($pair[1])),
        );
    }

    #[\NoDiscard]
    public function subtract(self $matrix): self
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            throw new MatricesMustBeOfTheSameDimension;
        }

        return new self(
            $this
                ->rows
                ->zip($matrix->rows)
                ->map(static fn($pair) => $pair[0]->subtract($pair[1])),
        );
    }

    #[\NoDiscard]
    public function multiplyBy(Number $number): self
    {
        $multiplier = RowVector::initialize($this->dimension->columns(), $number);

        return new self(
            $this
                ->rows
                ->map(static fn($row) => $row->multiplyBy($multiplier)),
        );
    }

    #[\NoDiscard]
    public function transpose(): self
    {
        return new self(
            $this
                ->columns
                ->map(static fn($column) => $column->asRow()),
        );
    }

    #[\NoDiscard]
    public function dot(self $matrix): self
    {
        return new self(
            $this
                ->rows
                ->map(
                    static fn($row) => $matrix
                        ->columns()
                        ->map(static fn($column) => $row->dot($column)),
                )
                ->map(RowVector::ofSequence(...)),
        );
    }

    #[\NoDiscard]
    public function isSquare(): bool
    {
        return $this->dimension->rows() === $this->dimension->columns();
    }

    #[\NoDiscard]
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
                    Range::until($row->dimension())->map(
                        static fn($i) => match ($i) {
                            $rows->size() => $row->get($i),
                            default => Number::zero(),
                        },
                    ),
                ));
            },
        );

        return new self($rows);
    }

    #[\NoDiscard]
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
                    Range::until($row->dimension())->map(
                        static fn($i) => match ($i) {
                            $rows->size() => Number::one(),
                            default => Number::zero(),
                        },
                    ),
                ));
            },
        );

        return new self($rows);
    }

    #[\NoDiscard]
    public function equals(self $matrix): bool
    {
        if (!$this->dimension->equals($matrix->dimension())) {
            return false;
        }

        return $this
            ->rows
            ->zip($matrix->rows)
            ->matches(static fn($pair) => $pair[0]->equals($pair[1]));
    }

    #[\NoDiscard]
    public function isSymmetric(): bool
    {
        return $this->equals($this->transpose());
    }

    #[\NoDiscard]
    public function isAntisymmetric(): bool
    {
        return $this
            ->multiplyBy(Number::of(-1))
            ->equals($this->transpose());
    }

    #[\NoDiscard]
    public function isInRowEchelonForm(): bool
    {
        $leadingZeros = $this->rows->map(
            static fn(RowVector $row) => $row
                ->toSequence()
                ->takeWhile(static fn($number) => $number->equals(Number::zero()))
                ->size(),
        );

        return $leadingZeros->equals($leadingZeros->sort(static fn($a, $b) => $a <=> $b)) &&
            $leadingZeros->equals($leadingZeros->distinct());
    }

    #[\NoDiscard]
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
    #[\NoDiscard]
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

        return self::fromColumns(
            $matrix
                ->columns()
                ->takeEnd(
                    $this->dimension->columns(),
                ),
        );
    }

    /**
     * @return Sequence<ColumnVector>
     */
    private function buildColumns(): Sequence
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        return Range::until($this->dimension->columns())
            ->map(fn($column) => $this->rows->map(
                static fn($row) => $row->get($column),
            ))
            ->map(ColumnVector::ofSequence(...));
    }

    private function reduceLowerTriangle(self $matrix): self
    {
        $rows = $matrix
            ->rows
            ->indices()
            ->reduce(
                $matrix->rows,
                static function(Sequence $rows, int $index): Sequence {
                    // reduce the matrix to an echelon form with leading ones
                    /**
                     * @psalm-suppress ArgumentTypeCoercion
                     * @var Sequence<RowVector>
                     */
                    $echeloned = $rows->take($index + 1);
                    /**
                     * @psalm-suppress ArgumentTypeCoercion
                     * @var Sequence<RowVector>
                     */
                    $toEchelon = $rows->drop($index + 1);
                    $reference = $echeloned->last()->match(
                        static fn($reference) => $reference,
                        static fn() => throw new LogicException,
                    );

                    return $echeloned
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
                                Number::one()->divideBy($row->lead()),
                            ),
                        ));
                },
            );

        return new self($rows);
    }

    private function reduceUpperTriangle(self $matrix): self
    {
        $indices = $matrix->rows->indices();

        $rows = $indices
            ->zip($indices->reverse())
            ->reduce(
                $matrix->rows->reverse(),
                static function(Sequence $rows, array $pair): Sequence {
                    [$reference, $index] = $pair;

                    // for each line remove the lines below by multiplying them
                    // by the number in j column of the row being manipulated
                    /**
                     * @psalm-suppress ArgumentTypeCoercion
                     * @var Sequence<RowVector>
                     */
                    $reduced = $rows->take($reference + 1);
                    /**
                     * @psalm-suppress ArgumentTypeCoercion
                     * @var Sequence<RowVector>
                     */
                    $toReduce = $rows->drop($reference + 1);

                    return $reduced->append(
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
                                    static fn() => throw new LogicException,
                                ),
                        ),
                    );
                },
            )
            ->reverse();

        return new self($rows);
    }
}
