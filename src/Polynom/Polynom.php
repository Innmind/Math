<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\{
    Algebra\Number,
    Monoid\Algebra,
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
    #[\NoDiscard]
    public function __invoke(Number $x): Number
    {
        return $this
            ->degrees
            ->map(static fn($degree) => $degree($x))
            ->prepend(Sequence::of($this->intercept))
            ->fold(Algebra::addition);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function zero(): self
    {
        /** @var Sequence<Degree> */
        $degrees = Sequence::of();

        return new self(Number::zero(), $degrees);
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function withDegree(int $degree, Number $coeff): self
    {
        return new self(
            $this->intercept,
            $this
                ->degrees
                ->exclude(static fn($known) => $known->is($degree))
                ->add(Degree::of($degree, $coeff)),
        );
    }

    /**
     * Return the intercept value
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function degree(int $degree): Maybe
    {
        return $this->degrees->find(
            static fn($known) => $known->is($degree),
        );
    }

    /**
     * Compute the derived number of x
     *
     * @param Number|null $limit Value that tend to 0 (default to 0.000000000001)
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function tangent(Number $x, ?Number $limit = null): Tangent
    {
        return Tangent::of($this, $x, $limit);
    }

    #[\NoDiscard]
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

    #[\NoDiscard]
    public function derivative(): self
    {
        [$intercept, $degrees] = $this
            ->degrees
            ->find(static fn($degree) => $degree->is(1))
            ->match(
                fn($degree) => [
                    $degree->coeff(),
                    $this->degrees->exclude(
                        static fn($degree) => $degree->is(1),
                    ),
                ],
                fn() => [Number::zero(), $this->degrees],
            );

        return new self(
            $intercept,
            $degrees->map(static fn($degree) => $degree->derivative()),
        );
    }

    #[\NoDiscard]
    public function integral(): Integral
    {
        return Integral::of($this);
    }

    #[\NoDiscard]
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
