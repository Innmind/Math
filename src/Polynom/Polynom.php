<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    divide,
    subtract
};
use Innmind\Math\Algebra\{
    Number,
    Integer,
    Operation
};
use Innmind\Immutable\Map;

final class Polynom
{
    private $intercept;
    private $degrees;

    public function __construct(Number $intercept = null, Degree ...$degrees)
    {
        $this->intercept = $intercept ?? new Integer(0);
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
     * @param Number $coeff
     *
     * @return self
     */
    public function withDegree(Integer $degree, Number $coeff): self
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
     * @return Number
     */
    public function intercept(): Number
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
     * @param Number $x
     *
     * @return Number
     */
    public function __invoke(Number $x): Number
    {
        return add(
            $this->intercept,
            ...$this->degrees->values()->reduce(
                [],
                static function(array $carry, Degree $degree) use ($x): array {
                    $carry[] = $degree($x);

                    return $carry;
                }
            )
        );
    }

    /**
     * Compute the derived number of x
     *
     * @param Number $x
     * @param Number|null $limit Value that tend to 0 (default to 0.000000000001)
     *
     * @return Number
     */
    public function derived(Number $x, Number $limit = null): Number
    {
        $limit = $limit ?? Tangent::limit();

        return divide(
            subtract(
                $this(add($x, $limit)),
                $this($x)
            ),
            $limit
        );
    }

    /**
     * Return the affine function (tangent) in the position x
     *
     * @param Number $x
     * @param Number|null $limit
     *
     * @return Tangent
     */
    public function tangent(Number $x, Number $limit = null): Tangent
    {
        return new Tangent($this, $x, $limit);
    }

    public function primitive(): self
    {
        $degrees = $this
            ->degrees
            ->values()
            ->map(static function(Degree $degree): Degree {
                return $degree->primitive();
            });

        if (!$this->intercept->equals(new Integer(0))) {
            $degrees = $degrees->add(
                new Degree(new Integer(1), $this->intercept)
            );
        }

        return new self(new Integer(0), ...$degrees);
    }

    public function derivative(): self
    {
        $degrees = $this->degrees;

        if ($degrees->contains(1)) {
            $intercept = $degrees->get(1)->coeff();
            $degrees = $degrees->remove(1);
        }

        return new self(
            $intercept ?? new Integer(0),
            ...$degrees
                ->values()
                ->map(static function(Degree $degree): Degree {
                    return $degree->derivative();
                })
        );
    }

    public function integral(): Integral
    {
        return new Integral($this);
    }

    public function __toString(): string
    {
        $polynom = $this
            ->degrees
            ->values()
            ->sort(static function(Degree $a, Degree $b): bool {
                return $b->degree()->higherThan($a->degree());
            })
            ->join(' + ');

        if (!$this->intercept->equals(new Integer(0))) {
            $intercept = $this->intercept instanceof Operation ?
                '('.$this->intercept.')' : (string) $this->intercept;

            $polynom = $polynom
                ->append(' + ')
                ->append($intercept);
        }

        return (string) $polynom;
    }
}
