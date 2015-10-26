<?php

namespace Innmind\Math\Polynom;

class Polynom
{
    protected $intercept;
    protected $degrees = [];

    public function __construct($intercept, array $degrees = [])
    {
        $this->intercept = (float) $intercept;

        foreach ($degrees as $degree) {
            if (!$degree instanceof Degree) {
                throw new \InvalidArgumentException(sprintf(
                    'A polynom degree must be an instance of "%s"',
                    Degree::class
                ));
            }

            $this->degrees[$degree->degree()] = $degree;
        }
    }

    /**
     * Create a new polynom with this added degree
     *
     * @param float $degree
     * @param float $coeff
     *
     * @return Polynom New instance
     */
    public function withDegree($degree, $coeff)
    {
        $degrees = $this->degrees;

        foreach ($degrees as $key => $d) {
            if ($d->degree() === (float) $degree) {
                unset($degrees[$key]);
            }
        }

        $degrees[] = new Degree($degree, $coeff);

        return new self($this->intercept, $degrees);
    }

    /**
     * Return the intercept value
     *
     * @return float
     */
    public function intercept()
    {
        return $this->intercept;
    }

    /**
     * Return the given degree
     *
     * @param float $degree
     *
     * @return Degree
     */
    public function degree($degree)
    {
        if (!$this->hasDegree($degree)) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown degree "%s"',
                $degree
            ));
        }

        foreach ($this->degrees as $d) {
            if ($d->degree() === (float) $degree) {
                return $d;
            }
        }
    }

    /**
     * Check if the polynom has the given degree
     *
     * @param float $degree
     *
     * @return bool
     */
    public function hasDegree($degree)
    {
        foreach ($this->degrees as $d) {
            if ($d->degree() === (float) $degree) {
                return true;
            }
        }

        return false;
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
        $result = $this->intercept;

        foreach ($this->degrees as $degree) {
            $result += $degree($x);
        }

        return $result;
    }
}
