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
    public function raw(): Native|Value
    {
        return $this->product();
    }

    public function product(): Native|Value
    {
        return Native::of($this->a->raw()->value() * $this->b->raw()->value());
    }

    #[\Override]
    public function optimize(): Implementation
    {
        $a = $this->a->optimize();
        $b = $this->b->optimize();

        if ($a instanceof Division) {
            $divisor = $a->divisor();

            if ($b->raw()->equals($divisor->raw())) {
                return $a->dividend();
            }
        }

        if ($b instanceof Division) {
            $divisor = $b->divisor();

            if ($a->raw()->equals($divisor->raw())) {
                return $b->dividend();
            }
        }

        return $this;
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
