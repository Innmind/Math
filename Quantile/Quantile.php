<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

class Quantile
{
    protected $dataset;
    protected $length;
    protected $min;
    protected $max;
    protected $mean;
    protected $median;
    protected $firstQuartile;
    protected $thirdQuartile;

    public function __construct(array $dataset)
    {
        $this->dataset = $this->clean($dataset);
        $this->length = count($this->dataset);
        $this
            ->buildMin()
            ->buildMax()
            ->buildMean()
            ->buildMedian()
            ->buildFirstQuartile()
            ->buildThirdQuartile();
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
    protected function clean(array $dataset): array
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
     * @return self
     */
    protected function buildMin(): self
    {
        $this->min = new Quartile(min($this->dataset));

        return $this;
    }

    /**
     * Extract the maximum value from the dataset
     *
     * @return self
     */
    protected function buildMax(): self
    {
        $this->max = new Quartile(max($this->dataset));

        return $this;
    }

    /**
     * Build the mean value from the dataset
     *
     * @return self
     */
    protected function buildMean(): self
    {
        $sum = array_sum($this->dataset);
        $this->mean = $sum / $this->length;

        return $this;
    }

    /**
     * Extract the median from the dataset
     *
     * @return self
     */
    protected function buildMedian(): self
    {
        $even = ($this->length % 2) === 0;
        $index = (ceil($this->length / 2)) - 1;

        if ($even) {
            $median = ($this->dataset[$index + 1] + $this->dataset[$index]) / 2;
        } else {
            $median = $this->dataset[$index];
        }

        $this->median = new Quartile($median);

        return $this;
    }

    /**
     * Extract the first quartile
     *
     * @return self
     */
    protected function buildFirstQuartile(): self
    {
        $this->firstQuartile = new Quartile($this->buildQuartile(0.25));

        return $this;
    }

    /**
     * Extract the first quartile
     *
     * @return self
     */
    protected function buildThirdQuartile(): self
    {
        $this->thirdQuartile = new Quartile($this->buildQuartile(0.75));

        return $this;
    }

    /**
     * Return the value describing the the quartile at the given percentage
     *
     * @param float $percentage
     *
     * @return float
     */
    protected function buildQuartile(float $percentage): float
    {
        if ($this->length === 2) {
            return ($this->dataset[0] + $this->dataset[1]) / 2;
        } else if ($this->length === 1) {
            return $this->dataset[0];
        }

        $position = $this->length * (float) $percentage;

        if (fmod($position, 1) !== 0) {
            $index = round($position);
            $value = ($this->dataset[$index] + $this->dataset[$index - 1]) / 2;
        } else {
            $value = $this->dataset[$position];
        }

        return $value;
    }
}
