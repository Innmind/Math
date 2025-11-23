<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 * @internal
 */
final class Multiplication implements Implementation
{
    /**
     * @param Sequence<Implementation> $values
     */
    private function __construct(
        private Implementation $first,
        private Implementation $second,
        private Sequence $values,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $first, Implementation $second): self
    {
        if ($first instanceof self) {
            if ($second instanceof self) {
                return new self(
                    $first->first,
                    $first->second,
                    $first->values->append($second->values),
                );
            }

            return new self(
                $first->first,
                $first->second,
                ($first->values)($second),
            );
        }

        return new self($first, $second, Sequence::of($first, $second));
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->product()->value();
    }

    #[\Override]
    public function equals(Implementation $number): bool
    {
        return $this->value() == $number->value();
    }

    public function product(): Implementation
    {
        $value = $this->values->reduce(
            1,
            static fn(int|float $carry, $number): int|float => $carry * $number->value(),
        );

        return Native::of($value);
    }

    #[\Override]
    public function optimize(): Implementation
    {
        return $this
            ->values
            ->drop(2)
            ->reduce(
                $this->doOptimize($this->first, $this->second),
                $this->doOptimize(...),
            )
            ->optimize();
    }

    #[\Override]
    public function toString(): string
    {
        $values = $this->values->map(
            static fn($number) => $number->format(),
        );

        return Str::of(' x ')->join($values)->toString();
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    private function doOptimize(
        Implementation $a,
        Implementation $b,
    ): Implementation {
        if ($a instanceof Division) {
            $divisor = $a->divisor()->optimize();

            if ($b->equals($divisor)) {
                return $a->dividend();
            }
        }

        if ($b instanceof Division) {
            $divisor = $b->divisor()->optimize();

            if ($a->equals($divisor)) {
                return $b->dividend();
            }
        }

        return self::of($a->optimize(), $b->optimize())->product(); // todo avoid computing concrete value
    }
}
