<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    divide,
    subtract
};
use Innmind\Math\Algebra\{
    NumberInterface,
    Number,
    Integer,
    OperationInterface
};
use Innmind\Immutable\Map;

final class Polynom
{
    private $intercept;
    private $degrees;

    public function __construct(NumberInterface $intercept = null, Degree ...$degrees)
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
     * @param NumberInterface $x
     * @param NumberInterface|null $limit Value that tend to 0 (default to 0.000000000001)
     *
     * @return NumberInterface
     */
    public function derived(
        NumberInterface $x,
        NumberInterface $limit = null
    ): NumberInterface {
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
     * @param NumberInterface $x
     * @param NumberInterface|null $limit
     *
     * @return Tangent
     */
    public function tangent(NumberInterface $x, NumberInterface $limit = null): Tangent
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
            $intercept = $this->intercept instanceof OperationInterface ?
                '('.$this->intercept.')' : (string) $this->intercept;

            $polynom = $polynom
                ->append(' + ')
                ->append($intercept);
        }

        return (string) $polynom;
    }
}
