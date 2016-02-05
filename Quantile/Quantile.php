<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

final class Quantile
{
    private $min;
    private $max;
    private $mean;
    private $median;
    private $firstQuartile;
    private $thirdQuartile;

    public function __construct(array $dataset)
    {
        $dataset = $this->clean($dataset);
        $length = count($dataset);
        $this
            ->buildMin($dataset)
            ->buildMax($dataset)
            ->buildMean($dataset, $length)
            ->buildMedian($dataset, $length)
            ->buildFirstQuartile($dataset, $length)
            ->buildThirdQuartile($dataset, $length);
    }

    /**
     * Return the minimum value
     *
     * @return Quartile
     */
    public function min(): Quartile
    {
        return $this->quartile(0);
    }

    /**
     * Return the maxinum value
     *
     * @return Quartile
     */
    public function max(): Quartile
    {
        return $this->quartile(4);
    }

    /**
     * Return the mean value
     *
     * @return float
     */
    public function mean(): float
    {
        return $this->mean;
    }

    /**
     * Return the median value
     *
     * @return Quartile
     */
    public function median(): Quartile
    {
        return $this->quartile(2);
    }

    /**
     * Return the quartile at the wished index
     *
     * @param int $index
     *
     * @return Quartile
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

        throw new \InvalidArgumentException(sprintf(
            'Unknown quartile %s',
            $index
        ));
    }

    /**
     * Transform every value into a numeric if necessary
     *
     * @param array $dataset
     *
     * @throws LogicException If a value is not a numeric
     *
     * @return array
     */
    private function clean(array $dataset): array
    {
        $cleaned = array_map(function($element) {
            if (!is_numeric($element)) {
                throw new \LogicException(sprintf(
                    'Only numeric values are accepted for a quantile (%s given)',
                    var_export($element, true)
                ));
            }

            if (!is_string($element)) {
                return $element;
            }

            if (preg_match('/^\d+\.\d+$/', $element)) {
                return (float) $element;
            }

            return (int) $element;
        }, $dataset);

        if (count($cleaned) === 0) {
            throw new \LogicException(
                'The dataset must contain at least one element'
            );
        }

        sort($cleaned);

        return $cleaned;
    }

    /**
     * Extract the minimum value from the dataset
     *
     * @param array $dataset
     *
     * @return self
     */
    private function buildMin(array $dataset): self
    {
        $this->min = new Quartile(min($dataset));

        return $this;
    }

    /**
     * Extract the maximum value from the dataset
     *
     * @param array $dataset
     *
     * @return self
     */
    private function buildMax(array $dataset): self
    {
        $this->max = new Quartile(max($dataset));

        return $this;
    }

    /**
     * Build the mean value from the dataset
     *
     * @param array $dataset
     * @param int $length
     *
     * @return self
     */
    private function buildMean(array $dataset, int $length): self
    {
        $sum = array_sum($dataset);
        $this->mean = $sum / $length;

        return $this;
    }

    /**
     * Extract the median from the dataset
     *
     * @param array $dataset
     * @param int $length
     *
     * @return self
     */
    private function buildMedian(array $dataset, int $length): self
    {
        $even = ($length % 2) === 0;
        $index = (ceil($length / 2)) - 1;

        if ($even) {
            $median = ($dataset[$index + 1] + $dataset[$index]) / 2;
        } else {
            $median = $dataset[$index];
        }

        $this->median = new Quartile($median);

        return $this;
    }

    /**
     * Extract the first quartile
     *
     * @param array $dataset
     * @param int $length
     *
     * @return self
     */
    private function buildFirstQuartile(array $dataset, int $length): self
    {
        $this->firstQuartile = new Quartile($this->buildQuartile(
            0.25,
            $dataset,
            $length
        ));

        return $this;
    }

    /**
     * Extract the first quartile
     *
     * @param array $dataset
     * @param int $length
     *
     * @return self
     */
    private function buildThirdQuartile(array $dataset, int $length): self
    {
        $this->thirdQuartile = new Quartile($this->buildQuartile(
            0.75,
            $dataset,
            $length
        ));

        return $this;
    }

    /**
     * Return the value describing the the quartile at the given percentage
     *
     * @param float $percentage
     * @param array $dataset
     * @param int $length
     *
     * @return float
     */
    private function buildQuartile(
        float $percentage,
        array $dataset,
        int $length
    ): float {
        if ($length === 2) {
            return ($dataset[0] + $dataset[1]) / 2;
        } else if ($length === 1) {
            return $dataset[0];
        }

        $position = $length * $percentage;

        if (fmod($position, 1) !== 0) {
            $index = round($position);
            $value = ($dataset[$index] + $dataset[$index - 1]) / 2;
        } else {
            $value = $dataset[$position];
        }

        return $value;
    }
}
