<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\{
    Algebra\Number,
    Algebra\Integer,
    Algebra\Operation,
    Algebra\Value,
};

/**
 * @psalm-immutable
 */
final class Degree
{
    private Integer\Positive $degree;
    private Number $coeff;

    private function __construct(Integer\Positive $degree, Number $coeff)
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
    public static function of(Integer\Positive $degree, Number $coeff): self
    {
        return new self($degree, $coeff);
    }

    public function degree(): Integer\Positive
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
            $this->degree->increment(),
            $this->coeff->divideBy($this->degree->add(Value::one)),
        );
    }

    public function derivative(): self
    {
        /** @psalm-suppress ArgumentTypeCoercion It must throw if we decrement below 1 as it means there is a bug somewhere */
        return new self(
            $this->degree->decrement(),
            $this->coeff->multiplyBy($this->degree),
        );
    }

    public function toString(): string
    {
        $coeff = $this->coeff instanceof Operation ?
            '('.$this->coeff->toString().')' : $this->coeff->toString();

        if ($this->degree->equals(Value::one)) {
            return $coeff.'x';
        }

        return \sprintf(
            '%sx^%s',
            $coeff,
            $this->degree->toString(),
        );
    }
}
