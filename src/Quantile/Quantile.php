<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

use function Innmind\Math\{
    divide,
    add,
    mean,
    median,
    min as minimum,
    max as maximum,
};
use Innmind\Math\{
    Regression\Dataset,
    Algebra\Number,
    Matrix\ColumnVector,
    Statistics\Mean,
    Exception\UnknownQuartile,
};

final class Quantile
{
    private Quartile $min;
    private Quartile $max;
    private Mean $mean;
    private Quartile $median;
    private Quartile $firstQuartile;
    private Quartile $thirdQuartile;

    public function __construct(Dataset $dataset)
    {
        $values = $dataset->ordinates()->toArray();
        \sort($values);
        $dataset = Dataset::of($values);

        $this->min = $this->buildMin($dataset);
        $this->max = $this->buildMax($dataset);
        $this->mean = $this->buildMean($dataset);
        $this->median = $this->buildMedian($dataset);
        $this->firstQuartile = $this->buildFirstQuartile($dataset);
        $this->thirdQuartile = $this->buildThirdQuartile($dataset);
    }

    /**
     * Return the minimum value
     */
    public function min(): Quartile
    {
        return $this->quartile(0);
    }

    /**
     * Return the maximum value
     */
    public function max(): Quartile
    {
        return $this->quartile(4);
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
        return $this->quartile(2);
    }

    /**
     * Return the quartile at the wished index
     */
    public function quartile(int $index): Quartile
    {
        switch ($index) {
            case 0:
                return $this->min;
            case 1:
                return $this->firstQuartile;
            case 2:
                return $this->median;
            case 3:
                return $this->thirdQuartile;
            case 4:
                return $this->max;
        }

        throw new UnknownQuartile((string) $index);
    }

    /**
     * Extract the minimum value from the dataset
     */
    private function buildMin(Dataset $dataset): Quartile
    {
        return new Quartile(minimum(...$dataset->ordinates()->numbers()));
    }

    /**
     * Extract the maximum value from the dataset
     */
    private function buildMax(Dataset $dataset): Quartile
    {
        return new Quartile(maximum(...$dataset->ordinates()->numbers()));
    }

    /**
     * Build the mean value from the dataset
     */
    private function buildMean(Dataset $dataset): Mean
    {
        return mean(...$dataset->ordinates()->numbers());
    }

    /**
     * Extract the median from the dataset
     */
    private function buildMedian(Dataset $dataset): Quartile
    {
        return new Quartile(median(...$dataset->ordinates()->numbers()));
    }

    /**
     * Extract the first quartile
     */
    private function buildFirstQuartile(Dataset $dataset): Quartile
    {
        return new Quartile($this->buildQuartile(
            new Number\Number(0.25),
            $dataset->ordinates(),
        ));
    }

    /**
     * Extract the third quartile
     */
    private function buildThirdQuartile(Dataset $dataset): Quartile
    {
        return new Quartile($this->buildQuartile(
            new Number\Number(0.75),
            $dataset->ordinates(),
        ));
    }

    /**
     * Return the value describing the quartile at the given percentage
     */
    private function buildQuartile(
        Number $percentage,
        ColumnVector $dataset
    ): Number {
        $dimension = $dataset->dimension();

        if ($dimension->value() === 2) {
            return divide(
                add($dataset->get(0), $dataset->get(1)),
                2,
            );
        }

        if ($dimension->value() === 1) {
            return $dataset->get(0);
        }

        $index = (int) $dimension
            ->multiplyBy($percentage)
            ->roundUp()
            ->value();

        return divide(
            add($dataset->get($index), $dataset->get($index - 1)),
            2,
        );
    }
}
