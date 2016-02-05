<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

class Polynom
{
    protected $intercept;
    protected $degrees = [];

    public function __construct(float $intercept, array $degrees = [])
    {
        $this->intercept = $intercept;

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
     * @param int $degree
     * @param float $coeff
     *
     * @return self
     */
    public function withDegree(int $degree, float $coeff): self
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
    public function intercept(): float
    {
        return $this->intercept;
    }

    /**
     * Return the given degree
     *
     * @param int $degree
     *
     * @return Degree
     */
    public function degree(int $degree): Degree
    {
        if (!$this->hasDegree($degree)) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown degree "%s"',
                $degree
            ));
        }

        foreach ($this->degrees as $d) {
            if ($d->degree() === $degree) {
                return $d;
            }
        }
    }

    /**
     * Check if the polynom has the given degree
     *
     * @param int $degree
     *
     * @return bool
     */
    public function hasDegree(int $degree): bool
    {
        foreach ($this->degrees as $d) {
            if ($d->degree() === $degree) {
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
    public function __invoke(float $x): float
    {
        $result = $this->intercept;

        foreach ($this->degrees as $degree) {
            $result += $degree($x);
        }

        return $result;
    }
}
