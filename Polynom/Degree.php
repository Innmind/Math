<?php

namespace Innmind\Math\Polynom;

class Degree
{
    protected $degree;
    protected $coeff;

    public function __construct($degree, $coeff)
    {
        $this->degree = (float) $degree;
        $this->coeff = (float) $coeff;
    }

    /**
     * Return the degree
     *
     * @return float
     */
    public function degree()
    {
        return $this->degree;
    }

    /**
     * Return the coeff
     *
     * @return float
     */
    public function coeff()
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
    public function __invoke($x)
    {
        return $this->coeff * pow((float) $x, $this->degree);
    }
}
