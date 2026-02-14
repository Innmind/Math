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
    private function __construct(
        private Implementation $a,
        private Implementation $b,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Implementation $a, Implementation $b): self
    {
        return new self($a, $b);
    }

    #[\Override]
    public function memoize(): Native
    {
        return $this->product();
    }

    public function product(): Native
    {
        return Native::of($this->a->memoize()->value() * $this->b->memoize()->value());
    }

    #[\Override]
    public function optimize(): Implementation
    {
        $a = $this->a->optimize();
        $b = $this->b->optimize();

        // (dividend/divisor)*b = dividend
        if ($a instanceof Division) {
            $divisor = $a->divisor();

            if ($b->memoize()->equals($divisor->memoize())) {
                return $a->dividend();
            }
        }

        // a*(dividend/divisor) = dividend
        if ($b instanceof Division) {
            $divisor = $b->divisor();

            if ($a->memoize()->equals($divisor->memoize())) {
                return $b->dividend();
            }
        }

        return new self($a, $b);
    }

    #[\Override]
    public function toString(): string
    {
        $values = $this->collect()->map(
            static fn($number) => $number->format(),
        );

        return Str::of(' x ')->join($values)->toString();
    }

    #[\Override]
    public function format(): string
    {
        return '('.$this->toString().')';
    }

    /**
     * @return Sequence<Implementation>
     */
    private function collect(): Sequence
    {
        return Sequence::of($this->a, $this->b)->flatMap(
            static fn($number) => match (true) {
                $number instanceof self => $number->collect(),
                default => Sequence::of($number),
            },
        );
    }
}
