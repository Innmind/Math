<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZeroError;

final class Division implements OperationInterface, NumberInterface
{
    private $dividend;
    private $divisor;

    public function __construct(
        NumberInterface $dividend,
        NumberInterface $divisor
    ) {
        if ($divisor->value() === 0) {
            throw new DivisionByZeroError;
        }

        $this->dividend = $dividend;
        $this->divisor = $divisor;
    }

    public function dividend(): NumberInterface
    {
        return $this->dividend;
    }

    public function divisor(): NumberInterface
    {
        return $this->divisor;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->result()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->result()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->result()->higherThan($number);
    }

    public function result(): NumberInterface
    {
        return new Number($this->dividend->value() / $this->divisor->value());
    }

    public function __toString(): string
    {
        $dividend = $this->dividend instanceof OperationInterface ?
            '('.$this->dividend.')' : (string) $this->dividend;
        $divisor = $this->divisor instanceof OperationInterface ?
            '('.$this->divisor.')' : (string) $this->divisor;

        return sprintf(
            '%s ÷ %s',
            $dividend,
            $divisor
        );
    }
}
