<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\desc;
use Innmind\Math\Algebra\{
    Number,
    Integer,
    Operation,
    Value,
    Addition,
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
    private Number $intercept;
    /** @var Sequence<Degree> */
    private Sequence $degrees;

    /**
     * @param Sequence<Degree> $degrees
     */
    private function __construct(Number $intercept, Sequence $degrees)
    {
        $this->intercept = $intercept;
        $this->degrees = $degrees;
    }

    /**
     * Compute the value for the given x
     */
    public function __invoke(Number $x): Number
    {
        $values = $this
            ->degrees
            ->map(static fn($degree) => $degree($x))
            ->toList();

        return Addition::of($this->intercept, ...$values);
    }

    /**
     * @psalm-pure
     */
    public static function zero(): self
    {
        /** @var Sequence<Degree> */
        $degrees = Sequence::of();

        return new self(Value::zero, $degrees);
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
     */
    public function withDegree(Integer\Positive $degree, Number $coeff): self
    {
        return new self(
            $this->intercept,
            $this
                ->degrees
                ->filter(static fn($known) => !$known->degree()->equals($degree))
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
     * @param positive-int $degree
     *
     * @return Maybe<Degree>
     */
    public function degree(int $degree): Maybe
    {
        return $this->degrees->find(
            static fn($known) => $known->degree()->equals(Integer::of($degree)),
        );
    }

    /**
     * Compute the derived number of x
     *
     * @param Number|null $limit Value that tend to 0 (default to 0.000000000001)
     */
    public function derived(Number $x, Number $limit = null): Number
    {
        $limit = $limit ?? Tangent::limit();

        return $this($x->add($limit))
            ->subtract($this($x))
            ->divideBy($limit);
    }

    /**
     * Return the affine function (tangent) in the position x
     */
    public function tangent(Number $x, Number $limit = null): Tangent
    {
        return Tangent::of($this, $x, $limit);
    }

    public function primitive(): self
    {
        $primitive = new self(
            Value::zero,
            $this
                ->degrees
                ->map(static fn($degree) => $degree->primitive()),
        );

        if (!$this->intercept->equals(Value::zero)) {
            $primitive = $primitive->withDegree(
                Integer::positive(1),
                $this->intercept,
            );
        }

        return $primitive;
    }

    public function derivative(): self
    {
        [$intercept, $degrees] = $this
            ->degrees
            ->find(static fn($degree) => $degree->degree()->equals(Value::one))
            ->match(
                fn($degree) => [
                    $degree->coeff(),
                    $this->degrees->filter(
                        static fn($degree) => !$degree->degree()->equals(Value::one),
                    ),
                ],
                fn() => [Value::zero, $this->degrees],
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
            ->sort(static fn($a, $b) => desc($a->degree(), $b->degree()))
            ->map(static fn($degree) => $degree->toString());
        $polynom = Str::of(' + ')->join($degrees);

        if (!$this->intercept->equals(Value::zero)) {
            $intercept = $this->intercept instanceof Operation ?
                '('.$this->intercept->toString().')' : $this->intercept->toString();

            $polynom = $polynom
                ->append(' + ')
                ->append($intercept);
        }

        return $polynom->toString();
    }
}
