<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\{
    Algebra\Number,
    Monoid\Addition,
};
use Innmind\Immutable\{
    Sequence,
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Polynom
{
    /**
     * @param Sequence<Degree> $degrees
     */
    private function __construct(
        private Number $intercept,
        private Sequence $degrees,
    ) {
    }

    /**
     * Compute the value for the given x
     */
    public function __invoke(Number $x): Number
    {
        return $this
            ->degrees
            ->map(static fn($degree) => $degree($x))
            ->prepend(Sequence::of($this->intercept))
            ->fold(Addition::monoid);
    }

    /**
     * @psalm-pure
     */
    public static function zero(): self
    {
        /** @var Sequence<Degree> */
        $degrees = Sequence::of();

        return new self(Number::zero(), $degrees);
    }

    /**
     * @psalm-pure
     */
    public static function interceptAt(Number $intercept): self
    {
        /** @var Sequence<Degree> */
        $degrees = Sequence::of();

        return new self($intercept, $degrees);
    }

    /**
     * Create a new polynom with this added degree
     *
     * @param int<1, max> $degree
     */
    public function withDegree(int $degree, Number $coeff): self
    {
        return new self(
            $this->intercept,
            $this
                ->degrees
                ->exclude(static fn($known) => $known->degree() === $degree)
                ->add(Degree::of($degree, $coeff)),
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
     *
     * @param int<1, max> $degree
     *
     * @return Maybe<Degree>
     */
    public function degree(int $degree): Maybe
    {
        return $this->degrees->find(
            static fn($known) => $known->degree() === $degree,
        );
    }

    /**
     * Compute the derived number of x
     *
     * @param Number|null $limit Value that tend to 0 (default to 0.000000000001)
     */
    public function derived(Number $x, ?Number $limit = null): Number
    {
        $limit = $limit ?? Tangent::limit();

        return $this($x->add($limit))
            ->subtract($this($x))
            ->divideBy($limit);
    }

    /**
     * Return the affine function (tangent) in the position x
     */
    public function tangent(Number $x, ?Number $limit = null): Tangent
    {
        return Tangent::of($this, $x, $limit);
    }

    public function primitive(): self
    {
        $primitive = new self(
            Number::zero(),
            $this
                ->degrees
                ->map(static fn($degree) => $degree->primitive()),
        );

        if (!$this->intercept->equals(Number::zero())) {
            $primitive = $primitive->withDegree(
                1,
                $this->intercept,
            );
        }

        return $primitive;
    }

    public function derivative(): self
    {
        [$intercept, $degrees] = $this
            ->degrees
            ->find(static fn($degree) => $degree->degree() === 1)
            ->match(
                fn($degree) => [
                    $degree->coeff(),
                    $this->degrees->exclude(
                        static fn($degree) => $degree->degree() === 1,
                    ),
                ],
                fn() => [Number::zero(), $this->degrees],
            );

        return new self(
            $intercept,
            $degrees->map(static fn($degree) => $degree->derivative()),
        );
    }

    public function integral(): Integral
    {
        return Integral::of($this);
    }

    public function toString(): string
    {
        $degrees = $this
            ->degrees
            ->sort(static fn($a, $b) => ($a->degree() <=> $b->degree()) * -1)
            ->map(static fn($degree) => $degree->toString());
        $polynom = Str::of(' + ')->join($degrees);

        if (!$this->intercept->equals(Number::zero())) {
            $intercept = $this->intercept->format();

            $polynom = $polynom
                ->append(' + ')
                ->append($intercept);
        }

        return $polynom->toString();
    }
}
