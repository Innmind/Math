<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\add;
use Innmind\Math\Algebra\{
    NumberInterface,
    Integer
};
use Innmind\Immutable\Map;

final class Polynom
{
    private $intercept;
    private $degrees;

    public function __construct(NumberInterface $intercept, Degree ...$degrees)
    {
        $this->intercept = $intercept;
        $this->degrees = new Map('int', Degree::class);

        foreach ($degrees as $degree) {
            $this->degrees = $this->degrees->put(
                $degree->degree()->value(),
                $degree
            );
        }
    }

    /**
     * Create a new polynom with this added degree
     *
     * @param Integer $degree
     * @param NumberInterface $coeff
     *
     * @return self
     */
    public function withDegree(Integer $degree, NumberInterface $coeff): self
    {
        $degrees = $this->degrees->put(
            $degree->value(),
            new Degree($degree, $coeff)
        );

        return new self(
            $this->intercept,
            ...$degrees->values()
        );
    }

    /**
     * Return the intercept value
     *
     * @return NumberInterface
     */
    public function intercept(): NumberInterface
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
     * @param NumberInterface $x
     *
     * @return NumberInterface
     */
    public function __invoke(NumberInterface $x): NumberInterface
    {
        return add(
            $this->intercept,
            ...$this->degrees->values()->reduce(
                [],
                function(array $carry, Degree $degree) use ($x): array {
                    $carry[] = $degree($x);

                    return $carry;
                }
            )
        );
    }
}
