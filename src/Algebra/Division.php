<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZeroError;

final class Division
{
    private $dividend;
    private $divisor;

    public function __construct(Number $dividend, Number $divisor)
    {
        if ($divisor->value() === 0) {
            throw new DivisionByZeroError;
        }

        $this->dividend = $dividend;
        $this->divisor = $divisor;
    }

    public function result(): Number
    {
        return new Number($this->dividend->value() / $this->divisor->value());
    }

    public function __toString(): string
    {
        return sprintf(
            '%s ÷ %s',
            $this->dividend,
            $this->divisor
        );
    }
}
