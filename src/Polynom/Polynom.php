<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    divide,
    subtract,
};
use Innmind\Math\Algebra\{
    Number,
    Integer,
    Operation,
};
use Innmind\Immutable\{
    Map,
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Polynom
{
    private Number $intercept;
    /** @var Map<int, Degree> */
    private Map $degrees;

    public function __construct(Number $intercept = null, Degree ...$degrees)
    {
        $this->intercept = $intercept ?? new Integer(0);
        /** @var Map<int, Degree> */
        $this->degrees = Map::of();

        foreach ($degrees as $degree) {
            $this->degrees = ($this->degrees)(
                $degree->degree()->value(),
                $degree,
            );
        }
    }

    /**
     * Compute the value for the given x
     */
    public function __invoke(Number $x): Number
    {
        $values = $this
            ->degrees
            ->values()
            ->map(static fn($degree) => $degree($x))
            ->toList();

        return add($this->intercept, ...$values);
    }

    /**
     * Create a new polynom with this added degree
     */
    public function withDegree(Integer $degree, Number $coeff): self
    {
        $degrees = ($this->degrees)(
            $degree->value(),
            new Degree($degree, $coeff),
        );

        return new self(
            $this->intercept,
            ...$degrees->values()->toList(),
        );
    }

    /**
     * Return the intercept value
     */
    public function intercept(): Number
    {
        return $this->intercept;
    }

    /**
     * Return the given degree
     */
    public function degree(int $degree): Degree
    {
        return $this->degrees->get($degree)->match(
            static fn($degree) => $degree,
            static fn() => throw new \LogicException,
        );
    }

    /**
     * Check if the polynom has the given degree
     */
    public function hasDegree(int $degree): bool
    {
        return $this->degrees->contains($degree);
    }

    /**
     * Compute the derived number of x
     *
     * @param Number|null $limit Value that tend to 0 (default to 0.000000000001)
     */
    public function derived(Number $x, Number $limit = null): Number
    {
        $limit = $limit ?? Tangent::limit();

        return divide(
            subtract(
                $this(add($x, $limit)),
                $this($x),
            ),
            $limit,
        );
    }

    /**
     * Return the affine function (tangent) in the position x
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
            $degrees = ($degrees)(
                new Degree(new Integer(1), $this->intercept)
            );
        }

        return new self(new Integer(0), ...$degrees->toList());
    }

    public function derivative(): self
    {
        [$intercept, $degrees] = $this
            ->degrees
            ->get(1)
            ->match(
                fn($degree) => [$degree->coeff(), $this->degrees->remove(1)],
                fn() => [new Integer(0), $this->degrees],
            );

        return new self(
            $intercept,
            ...$degrees
                ->values()
                ->map(static function(Degree $degree): Degree {
                    return $degree->derivative();
                })
                ->toList(),
        );
    }

    public function integral(): Integral
    {
        return new Integral($this);
    }

    public function toString(): string
    {
        $degrees = $this
            ->degrees
            ->values()
            ->sort(static function(Degree $a, Degree $b): int {
                if ($a->degree()->equals($b->degree())) {
                    return 0;
                }

                return $b->degree()->higherThan($a->degree()) ? 1 : -1;
            })
            ->map(static fn(Degree $degree): string => $degree->toString());
        $polynom = Str::of(' + ')->join($degrees);

        if (!$this->intercept->equals(new Integer(0))) {
            $intercept = $this->intercept instanceof Operation ?
                '('.$this->intercept->toString().')' : $this->intercept->toString();

            $polynom = $polynom
                ->append(' + ')
                ->append($intercept);
        }

        return $polynom->toString();
    }
}
