<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

final class Degree
{
    private $degree;
    private $coeff;

    public function __construct(int $degree, float $coeff)
    {
        $this->degree = $degree;
        $this->coeff = $coeff;
    }

    /**
     * Return the degree
     *
     * @return int
     */
    public function degree(): int
    {
        return $this->degree;
    }

    /**
     * Return the coeff
     *
     * @return float
     */
    public function coeff(): float
    {
        return $this->coeff;
    }

    /**
     * Compute the value for the given x
     *
     * @param float $x
     *
     * @return float
     */
    public function __invoke(float $x): float
    {
        return $this->coeff * pow($x, $this->degree);
    }
}
