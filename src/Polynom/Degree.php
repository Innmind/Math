<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\{
    Algebra\NumberInterface,
    Algebra\Integer
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

    /**
     * Compute the value for the given x
     */
    public function __invoke(NumberInterface $x): NumberInterface
    {
        return $this->coeff->multiplyBy($x->power($this->degree));
    }
}
