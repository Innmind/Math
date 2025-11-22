<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Degree
{
    /** @var int<1, max> */
    private int $degree;
    private Number $coeff;

    /**
     * @param int<1, max> $degree
     */
    private function __construct(int $degree, Number $coeff)
    {
        $this->degree = $degree;
        $this->coeff = $coeff;
    }

    /**
     * Compute the value for the given x
     */
    public function __invoke(Number $x): Number
    {
        return $this->coeff->multiplyBy($x->power(Number::of($this->degree)));
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $degree
     */
    public static function of(int $degree, Number $coeff): self
    {
        return new self($degree, $coeff);
    }

    /**
     * @return int<1, max>
     */
    public function degree(): int
    {
        return $this->degree;
    }

    public function coeff(): Number
    {
        return $this->coeff;
    }

    public function primitive(): self
    {
        return new self(
            $this->degree + 1,
            $this->coeff->divideBy(Number::of($this->degree)->add(Number::one())),
        );
    }

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
