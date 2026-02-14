<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Degree
{
    /**
     * @param int<1, max> $degree
     */
    private function __construct(
        private int $degree,
        private Number $coeff,
    ) {
    }

    /**
     * Compute the value for the given x
     */
    #[\NoDiscard]
    public function __invoke(Number $x): Number
    {
        return $this->coeff->multiplyBy($x->power(Number::of($this->degree)));
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $degree
     */
    #[\NoDiscard]
    public static function of(int $degree, Number $coeff): self
    {
        return new self($degree, $coeff);
    }

    /**
     * @return int<1, max>
     */
    #[\NoDiscard]
    public function degree(): int
    {
        return $this->degree;
    }

    #[\NoDiscard]
    public function coeff(): Number
    {
        return $this->coeff;
    }

    #[\NoDiscard]
    public function primitive(): self
    {
        return new self(
            $this->degree + 1,
            $this->coeff->divideBy(Number::of($this->degree)->add(Number::one())),
        );
    }

    #[\NoDiscard]
    public function derivative(): self
    {
        if ($this->degree === 1) {
            throw new \LogicException('Cannot derivate a degree of 1');
        }

        return new self(
            $this->degree - 1,
            $this->coeff->multiplyBy(Number::of($this->degree)),
        );
    }

    #[\NoDiscard]
    public function toString(): string
    {
        $coeff = $this->coeff->format();

        if ($this->degree === 1) {
            return $coeff.'x';
        }

        return \sprintf(
            '%sx^%s',
            $coeff,
            $this->degree,
        );
    }
}
