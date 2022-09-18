<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    divide,
    subtract,
};
use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Algebra\Operation,
};

/**
 * @psalm-immutable
 */
final class Degree
{
    private Integer $degree;
    private Number $coeff;

    private function __construct(Integer $degree, Number $coeff)
    {
        $this->degree = $degree;
        $this->coeff = $coeff;
    }

    /**
     * Compute the value for the given x
     */
    public function __invoke(Number $x): Number
    {
        return $this->coeff->multiplyBy($x->power($this->degree));
    }

    /**
     * @psalm-pure
     */
    public static function of(Integer $degree, Number $coeff): self
    {
        return new self($degree, $coeff);
    }

    public function degree(): Integer
    {
        return $this->degree;
    }

    public function coeff(): Number
    {
        return $this->coeff;
    }

    public function primitive(): self
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        return new self(
            add($this->degree, 1)->result(),
            divide(
                $this->coeff,
                add($this->degree, 1),
            ),
        );
    }

    public function derivative(): self
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        return new self(
            subtract($this->degree, 1)->result(),
            $this->coeff->multiplyBy($this->degree),
        );
    }

    public function toString(): string
    {
        $coeff = $this->coeff instanceof Operation ?
            '('.$this->coeff->toString().')' : $this->coeff->toString();

        if ($this->degree->equals(Integer::of(1))) {
            return $coeff.'x';
        }

        return \sprintf(
            '%sx^%s',
            $coeff,
            $this->degree->toString(),
        );
    }
}
