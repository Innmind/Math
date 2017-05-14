<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    divide,
    subtract
};
use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Integer,
    Algebra\OperationInterface
};

final class Degree
{
    private $degree;
    private $coeff;

    public function __construct(Integer $degree, NumberInterface $coeff)
    {
        $this->degree = $degree;
        $this->coeff = $coeff;
    }

    public function degree(): Integer
    {
        return $this->degree;
    }

    public function coeff(): NumberInterface
    {
        return $this->coeff;
    }

    public function primitive(): self
    {
        return new self(
            add($this->degree, 1)->result(),
            divide(
                $this->coeff,
                add($this->degree, 1)
            )
        );
    }

    public function derivative(): self
    {
        return new self(
            subtract($this->degree, 1)->result(),
            $this->coeff->multiplyBy($this->degree)
        );
    }

    /**
     * Compute the value for the given x
     */
    public function __invoke(NumberInterface $x): NumberInterface
    {
        return $this->coeff->multiplyBy($x->power($this->degree));
    }

    public function __toString(): string
    {
        $coeff = $this->coeff instanceof OperationInterface ?
            '('.$this->coeff.')' : $this->coeff;

        if ($this->degree->equals(new Integer(1))) {
            return $coeff.'x';
        }

        return sprintf(
            '%sx^%s',
            $coeff,
            $this->degree
        );
    }
}
