<?php
declare(strict_types = 1);

namespace Innmind\Math\Quantile;

use function Innmind\Math\asc;
use Innmind\Math\{
    Algebra\Number,
    Algebra\Real,
    Algebra\Value,
    Algebra\Integer,
    Algebra\Addition,
    Statistics\Mean,
    Statistics\Median,
    Exception\LogicException,
};
use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Quantile
{
    /** @var Sequence<Number> */
    private Sequence $values;

    /**
     * @param Sequence<Number> $values
     */
    private function __construct(Sequence $values)
    {
        $this->values = $values->sort(asc(...));
    }

    /**
     * @psalm-pure
     *
     * @param Sequence<Number> $values
     */
    public static function of(Sequence $values): self
    {
        return new self($values);
    }

    public function min(): Quartile
    {
        return $this->values->first()->match(
            Quartile::of(...),
            static fn() => throw new LogicException('Empty dataset'),
        );
    }

    public function max(): Quartile
    {
        return $this->values->last()->match(
            Quartile::of(...),
            static fn() => throw new LogicException('Empty dataset'),
        );
    }

    public function mean(): Number
    {
        /** @psalm-suppress InvalidArgument At least one value present */
        return Mean::of(...$this->values->toList());
    }

    /**
     * Return the median value
     */
    public function median(): Quartile
    {
        /** @psalm-suppress InvalidArgument At least one value present */
        return Quartile::of(Median::of(...$this->values->toList()));
    }

    public function firstQuartile(): Quartile
    {
        return Quartile::of($this->buildQuartile(Real::of(0.25)));
    }

    public function thirdQuartile(): Quartile
    {
        return Quartile::of($this->buildQuartile(Real::of(0.75)));
    }

    /**
     * Return the value describing the quartile at the given percentage
     */
    private function buildQuartile(Number $percentage): Number
    {
        /** @var positive-int */
        $index = (int) Integer::of($this->values->size())
            ->multiplyBy($percentage)
            ->roundUp()
            ->collapse()
            ->value();

        return $this->values->match(
            fn($first, $rest) => $rest->match(
                fn($second, $rest) => match ($rest->empty()) {
                    true => $first->add($second)->divideBy(Value::two),
                    false => Maybe::all(
                        $this->values->get($index),
                        $this->values->get($index - 1),
                    )
                        ->map(Addition::of(...))
                        ->map(static fn($sum) => $sum->divideBy(Value::two))
                        ->match(
                            static fn($quartile) => $quartile,
                            fn() => throw new LogicException("Operation not working for size {$this->values->size()}"),
                        ),
                },
                static fn() => $first,
            ),
            static fn() => throw new LogicException('Empty dataset'),
        );
    }
}
