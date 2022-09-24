<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

use function Innmind\Math\{
    min as minimum,
    max as maximum,
    asc,
};
use Innmind\Math\{
    Regression\Dataset,
    Algebra\Number,
    Algebra\Real,
    Algebra\Value,
    Algebra\Integer,
    Algebra\Addition,
    Matrix\ColumnVector,
    Statistics\Mean,
    Statistics\Median,
    Exception\LogicException,
};
use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Quantile
{
    private Quartile $min;
    private Quartile $max;
    private Mean $mean;
    private Quartile $median;
    private Quartile $firstQuartile;
    private Quartile $thirdQuartile;

    /**
     * @param Sequence<Number> $values
     */
    private function __construct(Sequence $values)
    {
        $values = $values->sort(asc(...));

        // todo do not pre-compute the values
        $this->min = $this->buildMin($values);
        $this->max = $this->buildMax($values);
        $this->mean = $this->buildMean($values);
        $this->median = $this->buildMedian($values);
        $this->firstQuartile = $this->buildFirstQuartile($values);
        $this->thirdQuartile = $this->buildThirdQuartile($values);
    }

    /**
     * @psalm-pure
     */
    public static function of(DataSet $dataset): self
    {
        return new self($dataset->ordinates()->toSequence());
    }

    /**
     * Return the minimum value
     */
    public function min(): Quartile
    {
        return $this->min;
    }

    /**
     * Return the maximum value
     */
    public function max(): Quartile
    {
        return $this->max;
    }

    /**
     * Return the mean value
     */
    public function mean(): Number
    {
        return $this->mean;
    }

    /**
     * Return the median value
     */
    public function median(): Quartile
    {
        return $this->median;
    }

    public function firstQuartile(): Quartile
    {
        return $this->firstQuartile;
    }

    public function thirdQuartile(): Quartile
    {
        return $this->thirdQuartile;
    }

    /**
     * Extract the minimum value from the dataset
     *
     * @param Sequence<Number> $values
     */
    private function buildMin(Sequence $values): Quartile
    {
        return $values->first()->match(
            Quartile::of(...),
            static fn() => throw new LogicException('Empty dataset'),
        );
    }

    /**
     * Extract the maximum value from the dataset
     *
     * @param Sequence<Number> $values
     */
    private function buildMax(Sequence $values): Quartile
    {
        return $values->last()->match(
            Quartile::of(...),
            static fn() => throw new LogicException('Empty dataset'),
        );
    }

    /**
     * Build the mean value from the dataset
     *
     * @param Sequence<Number> $values
     */
    private function buildMean(Sequence $values): Mean
    {
        return Mean::of(...$values->toList());
    }

    /**
     * Extract the median from the dataset
     *
     * @param Sequence<Number> $values
     */
    private function buildMedian(Sequence $values): Quartile
    {
        return Quartile::of(Median::of(...$values->toList()));
    }

    /**
     * Extract the first quartile
     *
     * @param Sequence<Number> $values
     */
    private function buildFirstQuartile(Sequence $values): Quartile
    {
        return Quartile::of($this->buildQuartile(
            Real::of(0.25),
            $values,
        ));
    }

    /**
     * Extract the third quartile
     *
     * @param Sequence<Number> $values
     */
    private function buildThirdQuartile(Sequence $values): Quartile
    {
        return Quartile::of($this->buildQuartile(
            Real::of(0.75),
            $values,
        ));
    }

    /**
     * Return the value describing the quartile at the given percentage
     *
     * @param Sequence<Number> $values
     */
    private function buildQuartile(
        Number $percentage,
        Sequence $values,
    ): Number {
        $index = (int) Integer::of($values->size())
            ->multiplyBy($percentage)
            ->roundUp()
            ->collapse()
            ->value();

        return $values->match(
            static fn($first, $rest) => $rest->match(
                static fn($second, $rest) => match ($rest->empty()) {
                    true => $first->add($second)->divideBy(Value::two),
                    false => Maybe::all(
                        $values->get($index),
                        $values->get($index - 1),
                    )
                        ->map(Addition::of(...))
                        ->map(static fn($sum) => $sum->divideBy(Value::two))
                        ->match(
                            static fn($quartile) => $quartile,
                            static fn() => throw new LogicException("Operation not working for size {$values->size()}"),
                        ),
                },
                static fn() => $first,
            ),
            static fn() => throw new LogicException('Empty dataset'),
        );
    }
}
