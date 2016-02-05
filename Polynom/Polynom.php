<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Immutable\TypedCollection;

final class Polynom
{
    private $intercept;
    private $degrees;

    public function __construct(float $intercept, array $degrees = [])
    {
        $this->intercept = $intercept;
        $degrees = new TypedCollection(Degree::class, $degrees); //verify the data
        $this->degrees = new TypedCollection(Degree::class, []);

        foreach ($degrees as $degree) {
            $this->degrees = $this->degrees->set($degree->degree(), $degree);
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
        return new self(
            $this->intercept,
            $this->degrees->set($degree, new Degree($degree, $coeff))->toPrimitive()
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
        return $this->degrees->hasKey($degree);
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
