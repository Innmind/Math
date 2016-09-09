<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Immutable\Map;

final class Polynom
{
    private $intercept;
    private $degrees;

    public function __construct(float $intercept, array $degrees = [])
    {
        $this->intercept = $intercept;
        $this->degrees = new Map('int', Degree::class);

        foreach ($degrees as $degree) {
            if (!$degree instanceof Degree) {
                throw new \InvalidArgumentException(sprintf(
                    'Each value must be an instance of "%s"',
                    Degree::class
                ));
            }

            $this->degrees = $this->degrees->put($degree->degree(), $degree);
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
        $degrees = $this->degrees->put($degree, new Degree($degree, $coeff));

        return new self(
            $this->intercept,
            array_combine(
                $degrees->keys()->toPrimitive(),
                $degrees->values()->toPrimitive()
            )
        );
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
        return $this->degrees->get($degree);
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
        return $this->degrees->contains($degree);
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
